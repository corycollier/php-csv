<?php

namespace PhpCsv;

class Table
{
    /**
     * Message to indicate an error trying to set rows before the headers are set.
     */
    const ERR_HEADERS_MUST_BE_SET = 'Cannot set rows before headers are set';

    /**
     * array of headers.
     *
     * @var array
     */
    protected $headers = array();

    /**
     * array of rows.
     *
     * @var array
     */
    protected $rows = array();

    /**
     * the full path to the csv file
     * @var string
     */
    protected $filename;

    /**
     * constructor.
     *
     * @param string $filename The full path to the csv file
     */
    public function __construct($filename = null)
    {
        $this->_filename = $filename;

        $this->init();
    }

    /**
     * parses a file into an array of lines.
     *
     * @param string $filename The full name of the csv file
     *
     * @return array An array of lines
     */
    protected function parseFile($filename = '')
    {
        return file($filename);
    }

    /**
     * parses a line, and returns an array of parts from it
     *
     * @param string $line a comma separated string
     * @return array an array of parts
     */
    protected function getPartsFromLine($line = '')
    {
        $parts = explode(',', $line);
        return array_map('trim', $parts);
    }

    /**
     * Iniit hook.
     * @return \PhpCsv\Table Returns $this, for object-chaining.
     */
    public function init()
    {
        $lines = $this->parseFile($this->_filename);

        $headers = $this->getHeadersFromLines($lines);
        $this->setHeaders($headers);

        $rows = $this->getRowsFromLines($lines);
        $this->setRows($rows);

        return $this;
    }

    /**
     * parses raw line data for rows.
     *
     * @param array $lines The raw array of lines.
     *
     * @return array An array of header information
     */
    protected function getHeadersFromLines(array $lines = array())
    {
        $parts = $this->getPartsFromLine($lines[0]);
        return $parts;
    }

    /**
     * setter for header values
     *
     * @param array $headers an array of headers to use.
     *
     * @return \PhpCsvTable\Table Returns $this, for object-chaining.
     */
    public function setHeaders(array $headers = array())
    {
        $this->headers = $headers;

        return $this;
    }

    /**
     * getter for the header values.
     *
     * @return array The headers.
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * parses raw line data for row data.
     *
     * @param    array    $lines the raw line data
     * @return array An array of rows
     */
    protected function getRowsFromLines(array $lines = array())
    {
        $result = array();
        $headers = $this->getHeaders();
        if (! $headers) {
            throw new \PhpCsv\Exception(self::ERR_HEADERS_MUST_BE_SET);
        }

        foreach ($lines as $line) {
            $row = $this->getPartsFromLine($line);
            $result[] = array_combine($headers, $row);
        }

        return $result;
    }

    /**
     * setter for the row values
     *
     * @param array $rows An array of rows to use for the data
     *
     * @return \PhpCsv\Table Returns $this, for object-chaining.
     */
    public function setRows(array $rows = array())
    {
        $this->rows = $rows;

        return $this;
    }

    /**
     * getter for the row values
     * @return array The rows.
     */
    public function getRows()
    {
        return $this->rows;
    }
}
