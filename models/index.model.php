<?php

class IndexModel extends Database
{
	protected function setAllPerson() {

		return self::query( "SELECT * FROM people WHERE 1 ORDER BY created_at DESC" );
	}
}