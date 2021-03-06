<?php
/**
 *	OUTRAGEbot - PHP 5.3 based IRC bot
 *
 *	Author:		Jannis Pohl <mave1337@gmail.com>
 *
 *	Version:        2.0.0-Alpha
 *	Git commit:     0638fa8bb13e1aca64885a4be9e6b7d78aab0af7
 *	Committed at:   Wed Aug 24 23:16:56 BST 2011
 *
 *	Licence:	http://www.typefish.co.uk/licences/
 */


class Translation extends Script
{
	public function onChannelCommand($sChannel, $sNickname, $sCommand, $sArguments)
        {
		$sCommand = strtolower($sCommand);

                if ($sCommand == "trans")
		{
			if(!$sArguments)
        		{
        			$this->Notice($sNickname, "USAGE: trans [fromLang] [toLang] [Message]");
        			return END_EVENT_EXEC;
			}

			$aArguments = explode(' ', $sArguments, 3);
			$sURL = "http://ajax.googleapis.com/ajax/services/language/translate?v=1.0&q=".rawurlencode($aArguments[2]).
			"&langpair=".rawurlencode($aArguments[0].'|'.$aArguments[1]);

			$sJSON = file_get_contents($sURL);

			if(preg_match("/{\"translatedText\":\"([^\"]+)\"/i", $sJSON, $aMatches))
			{
				$sTranslation = html_entity_decode($aMatches[1], ENT_COMPAT, "UTF-8");

				$this->Message($sChannel, $sTranslation);
			}

			return END_EVENT_EXEC;
		}
	}
}
