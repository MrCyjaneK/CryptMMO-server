<?php
// Copied from old game source
// Don't set $try in requests
function getString($textname, $language = "getUserLang", $try = 0, $default = '++++ THIS STRING IS NOT TRANSLATED, <a href="/game.php?action=translate">CONTRIBUTE</a> ++++') {
    $link = "https://dogemmo.mrcyjanek.net/game.php?action=translate&textname=".urlencode($textname)."&language=".urlencode($language);
    $default_text = '++++ THIS STRING IS NOT TRANSLATED, <a href="/game.php?action=translate">CONTRIBUTE</a> ++++';
    $textname = strtoupper($textname);
    global $user;
    if ($language == 'getUserLang') {
        $language = isset($user->langcode) ? $user->langcode : 'EN';
    }
    $language = strtoupper($language);
    global $db;
    $query = $db->prepare("SELECT * FROM `translation` WHERE `textname`=:textname AND language=:language");
    $query->bindParam(":textname",$textname);
    $query->bindParam(":language",$language);
    $query->execute();
    $query = $query->fetchAll();
    if ($query == []) {
        // Eh... No translation found, insert default and beg for contribution
        $insert = $db->prepare("INSERT INTO `translation`(`textname`, `language`, `text`) VALUES (:textname, :language, :text)");
        $insert->bindParam(":textname",$textname);
        $insert->bindParam(":language",$language);
        $insert->bindParam(":text",$default_text);
        $insert->execute();
        // ATTENTION, RECURSION
        if ($try > 5) {
            kill("Critical non-fatal error occured in getString translation module");
        }
        return getString($textname, $language, $try+1);
    }
    $tl = $query[0]['text'];
    if (substr($tl,0,13) == substr($default_text,0,13)) {
            return $tl." <a href=\"".$link."\">✏</a>";
    }
    return $tl;
}
