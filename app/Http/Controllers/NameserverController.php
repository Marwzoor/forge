<?php

namespace App\Http\Controllers;

use \Input, \Mail, \Validator;

use App\Models\Nameserver;
use Illuminate\Http\Request;

use App\Http\Requests;

class NameserverController extends Controller
{
    public function getSearch() {
    	return view('nameserver.search');
    }

    public function postSearch() {
    	$validator = Validator::make(Input::all(), [
            'domain' 		=> 'required',
        ]);

        if($validator->fails()) {
        	return response()->json([
        		"success"	=> false,
        		"message"	=> $validator->errors()->first()
        	], 400);
        }

    	$domain = Input::get('domain', false);

    	$nameservers = dns_get_record( $domain, DNS_NS );


    	if(!isset($nameservers[0])) {
	    	return response()->json([
				"message"	=> sprintf(
					'No nameservers found for domain <code>%s</code>.',
					$domain
				),
				"success"	=> false,
			], 404);
	    }

    	$matchedNameserver = false;

    	foreach($nameservers as $nameserver) {
    		if(!isset($nameserver["target"])) {
    			continue;
    		}

    		$dbNameserver = Nameserver::where('approved', '=', true)
    			->where('hostname', '=', $nameserver["target"])
    			->first();

    		if(!is_null($dbNameserver)) {
    			$matchedNameserver = $dbNameserver;
    		}
    	}

    	if($matchedNameserver === false) {
    		return response()->json([
    			"message"	=> sprintf(
    				'Nameserver <code>%s</code> not found in our registry. Have information about it? <a target="_BLANK" href="%s">Submit it here.</a>',
    				$nameservers[0]["target"],
    				action( 'NameserverController@getSubmit', ['hostname' => $nameservers[0]["target"]] )
    			),
    			"success"	=> false,
    		], 404);
    	}

    	return response()->json([
    		"success"			=> true,
    		"message"			=> "Nameserver found!",
    		"companyName"		=> $matchedNameserver->company_name,
    		"companyUrl"		=> $matchedNameserver->company_url,
    		"domain"			=> $domain,
    	], 200);
    }

    public function getSubmit() {
    	return view('nameserver.submit');
    }

    public function postSubmit() {
    	$validator = Validator::make(Input::all(), [
            'hostname' 		=> 'required|unique:nameservers,hostname',
            'company_name' 	=> 'required',
            'company_url'	=> 'required|url',
        ]);

        if($validator->fails()) {
        	return response()->json([
        		"success"	=> false,
        		"message"	=> $validator->errors()->first()
        	], 400);
        }

      	$hostname = Input::get('hostname');
    	$companyName = Input::get('company_name');
    	$companyUrl = Input::get('company_url');
    	$confirmationCode = str_random(30);

    	$nameserver = new Nameserver();
    	$nameserver->company_name = $companyName;
    	$nameserver->company_url = $companyUrl;
    	$nameserver->confirmation_code = $confirmationCode;
    	$nameserver->hostname = $hostname;
    	$nameserver->submitter_ip = request()->ip();
    	$nameserver->save();

    	Mail::send('emails.confirm-nameserver', ['nameserver' => $nameserver, 'confirmationCode' => $confirmationCode], function ($mail) {
            $mail->from('carlmartinwerner@gmail.com', 'Martin Werner App');

            $mail->to('carlmartinwerner@gmail.com', 'Martin Werner')
            	->subject('Confirm new nameserver submission');
        });

        return response()->json([
        	"success"	=> true,
        	"message"	=> "Nameserver submitted!",
        ], 200);
    }

    public function confirmNameserver($code) {
    	$nameserver = Nameserver::where('confirmation_code', '=', $code)->first();

    	if(is_null($nameserver)) {
    		return response("Action not permitted", 403);
    	}

    	$nameserver->approved = true;
    	$nameserver->confirmation_code = null;
    	$nameserver->save();

    	return response("Nameserver confirmed.", 200);
    }

    public function deleteNameserver($code) {
    	$nameserver = Nameserver::where('confirmation_code', '=', $code)->first();

    	if(is_null($nameserver)) {
    		return response("Action not permitted", 403);
    	}

    	$nameserver->delete();

    	return response("Nameserver deleted.", 200);
    }
}
