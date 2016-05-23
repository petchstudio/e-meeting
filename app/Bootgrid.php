<?php

namespace App;

use DB;
use Illuminate\Http\Request;

class Bootgrid
{

    protected $connection;

    protected $request;

    protected $rowCount;

    protected $current;

    protected $sorts;

    protected $searchPhrase;

    protected $skip;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->rowCount = intval($request->input('rowCount', 10));
        $this->current = intval($request->input('current', 1));
        $this->sorts = $request->input('sort', false);
        $this->searchPhrase = $request->input('searchPhrase', false);
        $this->skip = $this->rowCount*($this->current-1);
    }

    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    public function setWhereSearch($connection)
    {
        $this->connection = $connection;
    }

    public function hasSearch()
    {
        return $this->request->has('searchPhrase');
    }

    public function getKeyword()
    {
        return $this->searchPhrase;
    }

    public function setSort(array $orders)
    {
        if( !$this->request->has('sort') )
        {
            $this->sorts = $orders;
        }
    }

    public function get()
    {
        $total = $this->connection->count();

        $this->connection = $this->connection->skip($this->skip)->take($this->rowCount);

        if( $this->sorts )
        {
            foreach ($this->sorts as $key => $value) {
                $this->connection = $this->connection->orderBy($key, $value);
            }
        }

        return  array(
            'current'   => $this->current,
            'rowCount'  => $this->rowCount,
            'rows'  => $this->connection->get(),
            'total' => $total,
        );
    }

    public static function __callStatic($method, $parameters)
    {
        $instance = new static;

        return call_user_func_array([$instance, $method], $parameters);
    }
}
