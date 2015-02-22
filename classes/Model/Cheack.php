<?php

defined('SYSPATH') or die('No direct script access.');

class Model_Cheack extends Model {

    public static function unique_username($username) {
        // Check if the username already exists in the database
        return !DB::select(array(DB::expr('COUNT(username)'), 'total'))
                        ->from('users')
                        ->where('username', '=', $username)
                        ->execute()
                        ->get('total');
    }

    public static function unique_email($email) {
        // Check if the username already exists in the database
        return !DB::select(array(DB::expr('COUNT(username)'), 'total'))
                        ->from('users')
                        ->where('email', '=', $email)
                        ->execute()
                        ->get('total');
    }
    
    public static function unique_mailing($email)
	    {
        // Check if the username already exists in the database
	
        return !DB::select(array(DB::expr('COUNT(email)'), 'total'))
                        ->from('mailing')
                        ->where('email', '=', $email)
                        ->execute()
                        ->get('total');
    }

}
