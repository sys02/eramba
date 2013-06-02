<?php

include_once('configuration.inc');


# http://samjlevy.com/2010/09/php-login-script-using-ldap-verify-group-membership/

function ldap_authenticate($user, $password) {

    global $ldap;

    // Active Directory server
    $ldap_host = $ldap[ldap_server];
    $ldap_dn = $ldap[ldap_dn];
    $ldap_usr_dom = $ldap[usr_dom];

	#echo "settings: $ldap_host // $ldap_dn // $lda_usr_dom<br>";
 
    // Active Directory user group
    $ldap_user_group = "WebUsers";
    // Active Directory manager group
    $ldap_manager_group = "WebManagers";
 
    // connect to active directory
    $ldap = ldap_connect($ldap_host);
 
    // verify user and password
    if($bind = @ldap_bind($ldap, $user . $ldap_usr_dom, $password)) {
        // valid
        // check presence in groups
        $filter = "(sAMAccountName=" . $user . ")";
        $attr = array("memberof");
        $result = ldap_search($ldap, $ldap_dn, $filter, $attr) or exit("Unable to search LDAP server");
        $entries = ldap_get_entries($ldap, $result);
        ldap_unbind($ldap);
 
#        // check groups
#        foreach($entries[0]['memberof'] as $grps) {
#            // is manager, break loop
#            if (strpos($grps, $ldap_manager_group)) { $access = 2; break; }
# 
#            // is user
#            if (strpos($grps, $ldap_user_group)) $access = 1;
#        }

	# forced not to look at groups
	$access = 1;
 
        if ($access != 0) {
            // establish session variables
            $_SESSION['user'] = $user;
            $_SESSION['access'] = $access;
            return true;
        } else {
            // user has no rights
            return false;
        }
 
    } else {
        // invalid name or password
        return false;
    }
}

function get_members($group=FALSE,$inclusive=FALSE) {


#// Example Output
# 
#print_r(get_members()); // Gets all users in 'Users'
# 
#print_r(get_members("Test Group")); // Gets all members of 'Test Group'
# 
#print_r(get_members(
#            array("Test Group","Test Group 2")
#        )); // EXCLUSIVE: Gets only members that belong to BOTH 'Test Group' AND 'Test Group 2'
# 
#print_r(get_members(
#            array("Test Group","Test Group 2"),TRUE
#        )); // INCLUSIVE: Gets members that belong to EITHER 'Test Group' OR 'Test Group 2'
#


    // Active Directory server
    $ldap_host = "ad.domain";
 
    // Active Directory DN
    $ldap_dn = "CN=Users,DC=ad,DC=domain";
 
    // Domain, for purposes of constructing $user
    $ldap_usr_dom = "@".$ldap_host;
 
    // Active Directory user
    $user = "jdoe";
    $password = "password1234!";
 
    // User attributes we want to keep
    // List of User Object properties:
    // http://www.dotnetactivedirectory.com/Understanding_LDAP_Active_Directory_User_Object_Properties.html
    $keep = array(
        "samaccountname",
        "distinguishedname"
    );
 
    // Connect to AD
    $ldap = ldap_connect($ldap_host) or die("Could not connect to LDAP");
    ldap_bind($ldap,$user.$ldap_usr_dom,$password) or die("Could not bind to LDAP");
 
     // Begin building query
     if($group) $query = "(&"; else $query = "";
 
     $query .= "(&(objectClass=user)(objectCategory=person))";
 
    // Filter by memberOf, if group is set
    if(is_array($group)) {
        // Looking for a members amongst multiple groups
            if($inclusive) {
                // Inclusive - get users that are in any of the groups
                // Add OR operator
                $query .= "(|";
            } else {
                // Exclusive - only get users that are in all of the groups
                // Add AND operator
                $query .= "(&";
            }
 
            // Append each group
            foreach($group as $g) $query .= "(memberOf=CN=$g,$ldap_dn)";
 
            $query .= ")";
    } elseif($group) {
        // Just looking for membership of one group
        $query .= "(memberOf=CN=$group,$ldap_dn)";
    }
 
    // Close query
    if($group) $query .= ")"; else $query .= "";
 
    // Uncomment to output queries onto page for debugging
    // print_r($query);
 
    // Search AD
    $results = ldap_search($ldap,$ldap_dn,$query);
    $entries = ldap_get_entries($ldap, $results);
 
    // Remove first entry (it's always blank)
    array_shift($entries);
 
    $output = array(); // Declare the output array
 
    $i = 0; // Counter
    // Build output array
    foreach($entries as $u) {
        foreach($keep as $x) {
            // Check for attribute
            if(isset($u[$x][0])) $attrval = $u[$x][0]; else $attrval = NULL;
 
            // Append attribute to output array
            $output[$i][$x] = $attrval;
        }
        $i++;
    }
 
    return $output;
}


?>
