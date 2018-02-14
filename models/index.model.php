<?php

class IndexModel extends Database
{
	protected function set_AllPerson() {

		return self::query( "SELECT * FROM people WHERE 1 ORDER BY created_at DESC" );
	}
}