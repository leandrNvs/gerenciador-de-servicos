<?php

namespace Src\Database;

use PDO;
use Src\Foundation\Application;

final class Database
{
    /**
     * The database connection
     * 
     * @var \PDO
     */
    private $connection;

    /**
     * Initialize the database connection
     * 
     * @param \Src\Foundation\Application
     * @return void
     */
    public function __construct(private Application $app)
    {
        $this->initialize();
    }

    /**
     * Start a database connection
     * 
     * @return void
     */
    private function initialize()
    {
        $this->connection = new PDO('sqlite:' . $this->app['database'] . 'gerenciamento.sqlite');
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    /**
     * Retrieve a database connection
     * 
     * @return \PDO
     */
    public function get()
    {
        return $this->connection;
    }
}