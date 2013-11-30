<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * MY Base Model
 *
 * The Base model implements standard CRUD functions that can be
 * used and overriden by module models. This helps to maintain
 * a standard interface to program to, and makes module creation
 * faster.
 *
 * @package    Mycms
 * @subpackage MY_Model
 * @category   Models
 * @author     Ahmad Milzam
 * @link       http://ahmadmilzam.com
 *
 */
class MY_Model extends CI_Model {

    /**
     * The name of the db table this model primarily uses.
     *
     * @var string
     * @access protected
     */
    protected $_table = '';

    /**
     * The primary key of the table.
     * Set to id by default.
     * Changeable
     * @var string
     * @access protected
     */
    protected $_primary_key = '';

    /**
     * Filter function for primary key.
     * Changeable.
     * @var string
     * @access protected
     */
    protected $_primary_filter = 'intval';

    /**
     * Default order for every table.
     * @var string
     * @access protected
     */
    protected $_order_by ='';

    /**
     * Variable check if the table using timestampe field.
     * @var boolean
     * @access protected
     */
    protected $_timestamps = FALSE;

    /**
     * The type of date/time field used for created_on and modified_on fields.
     * Valid types are: 'int', 'datetime', 'date'
     *
     * @var string
     * @access protected
     */
    protected $_date_format = 'datetime';

    /**
     * Field name to use to the created time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $_created_field = 'created_on';

    /**
     * Field name to use to the modified time column in the DB table.
     *
     * @var string
     * @access protected
     */
    protected $_modified_field = 'modified_on';

    /**
     * Default array of validation rules
     * @var array
     * @access public
     */
    public $rules = array();
    /**
     * example:
     * public $rules    = array(
     *                      'email'     => array('field' => 'email_text','label' => 'Email', 'rules' => 'required'),
     *                      'username'  => array('field' => 'username_text','label' => 'Username', 'rules' => 'required'),
     *                      'password'  => array('field' => 'password_text','label' => 'Password', 'rules' => 'required')
     *                  );
     */


    public function __construct()
    {
        parent::__construct();
        //Do your magic here
    }

    //---------------------------------------------------------------
    // !COMMON CRUD FUNCTIONS
    //---------------------------------------------------------------

    /**
     * perform a get data from database.
     * by default it will return all records.
     * if $id is passes, then it will return a single record.
     * @param  boolean $id default parameter is FALSE for return all records.
     * @param  boolean $single
     * @return object || array
     */
    public function get($id = NULL, $single = FALSE)
    {
        if($id)
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);//filter the id with intval as default. *for little bit of security.

            $this->where($this->_primary_key, $id);
            $method = 'row';// if $id, then method is set to row
        }
        elseif($single) //if single parameter is TRUE, the return single object, uses with get_by();
        {
            $method = 'row';
        }
        else
        {
            $method = 'result';// default method is result for return all records.
        }
        if (!count($this->db->ar_orderby))//if the order method is empty.
        {
            $this->order_by($this->_order_by);//order a result with default order_by.
        }

        return $this->db->get($this->_table)->$method();
    }

    /**
     * perform a get data from database.
     * with a where parameter.
     *
     * example : get use by email address / username
     * @param  array $where
     * @param  boolean $single
     * @return result
     */
    public function get_by($where, $single = FALSE)
    {
        $this->where($where);
        return $this->get($id = NULL, $single);
    }

    /**
     * Inserts a row of data into the database. or update a row if $id is set.
     * @param  array  $data [description]
     * @param  boolean $id   [description]
     */
    public function save($data, $id = NULL)
    {
        if ($this->_timestamps)//if timestamp parameter is set, then set the curr time.
        {
            $id || $data[$this->_created_field] = $this->set_date();
            $data[$this->_modified_field] = $this->set_date();
            //if $id is set, then do nothing.
            //but if it is not set, then $data[created_field] is set to curr time
        }

        //insert
        if( ! $id)
        {
            !isset($data[$this->_primary_key]) || $data[$this->_primary_key] = NULL;
            //check for the data.
            //if $data[primary_key] is not set, then do nothing.
            //but if is set, then $data[_primary] is force to null

            $this->db->insert($this->_table, $data);
            $id = $this->db->insert_id();
        }
        //update
        else
        {
            $filter = $this->_primary_filter;
            $id = $filter($id);

            $this->where($this->_primary_key, $id);
            $this->db->update($this->_table, $data);
        }
        return $id;
    }

    /**
     * Performs a delete on the record specified by an id.
     * @param  boolean $id id of a record
     */
    public function delete($id = NULL)
    {
        $filter = $this->_primary_filter;
        $id = $filter($id);

        if(!$id)
        {
            return FALSE;
        }
        if ($this->_is_data_exist($id) === 0) //perform a check if data with this id is exist
        {
            return FALSE;//if not return false
        }

        $this->where($this->_primary_key, $id);
        $this->db->delete($this->_table);
        return TRUE;
    }//end delete()

    /**
     * Performs a multiple row delete on the record specified by an array of id.
     * @param  array $id id of a record
     */
    public function bulk_delete($bulk_id)
    {
        if(!is_array($bulk_id))
        {
            return FALSE;
        }

        $filter = $this->_primary_filter;

        foreach ($bulk_id as $id)
        {
            $id = $filter($id);
        }

        if ($this->_is_data_exist($bulk_id, $where_in = TRUE) === 0) //perform a check if data with this id is exist, if second param set to TRUE, it will run where_in() function.
        {
            return FALSE;//if not return false
        }

        $this->where_in($this->_primary_key, $bulk_id);
        $this->db->delete($this->_table);
        return TRUE;
    }//end delete()

    /**
     * Create an unique seo url link or slug
     * using the following code in codeigniter or for core php.
     * A clean url is an url which contains
     * only alphabets (letters), numbers and a hyphen or an underscore.
     *
     * While you are creating a new entry you will need to send only the first three parameters
     * but when you are editing an existing entry then you need to send the last two parameters.
     *
     * @param  string $title        [description]
     * @param  string $field        [description]
     * @param  string $key          [description]
     * @param  int $value        [description]
     * @return string               [description]
     */
    function create_unique_slug($title, $field = 'slug', $key = NULL, $value = NULL)
    {
        $slug = url_title($title);
        $slug = strtolower($slug);
        $i = 0;
        $params = array ();
        $params[$field] = $slug;

        if($key) $params["$key !="] = $value;

        while ($this->db->where($params)->get($this->_table)->num_rows())
        {
            if (!preg_match ('/-{1}[0-9]+$/', $slug ))
                $slug .= '-' . ++$i;
            else
                $slug = preg_replace ('/[0-9]+$/', ++$i, $slug );

            $params [$field] = $slug;
        }

        return $slug;
    }

    //---------------------------------------------------------------
    // !UTILITY FUNCTIONS
    //---------------------------------------------------------------

    /**
     * Funtion for check if data is exist or not.
     * if not it will return (int) = 0
     *
     * @return int
     */
    protected function _is_data_exist($value, $bulk = FALSE)
    {
        if($bulk)
        {
            if(is_array($value))
            {
                $this->where_in($this->_primary_key, $value);
            }
        }

        else
        {
            $this->where($this->_primary_key, $value);
        }

        return $this->count_all();
    }

    /**
     * Returns the number of rows in the table with param 'where'.
     *
     * @return int
     */
    public function count_where($column, $value)
    {
        $this->where($column, $value);
        return $this->count_all();
    }


    /**
     * Returns the number of rows in the table.
     *
     * @return int
     */
    public function count_all()
    {
        return $this->db->count_all_results($this->_table);

    }//end count_all()

    /**
     * Sets the limit portion of the query in a chainable format.
     *
     * @param int $limit  An int showing the max results to return.
     * @param int $offset An in showing how far into the results to start returning info.
     */
    public function limit($limit=0, $offset=0)
    {
        return $this->db->limit($limit, $offset);
    }//end limit()


    /**
     * Sets the where portion of the query in a chainable format.
     *
     * @param mixed  $field The field to search the db on. Can be either a string with the field name to search, or an associative array of key/value pairs.
     * @param string $value The value to match the field against. If $field is an array, this value is ignored.
     */
    public function where($field=FALSE, $value=FALSE)
    {
        if (!empty($field))
        {
            if (is_string($field))
            {
                $this->db->where($field, $value);
            }
            else if (is_array($field))
            {
                $this->db->where($field);
            }
        }

        return $this;

    }//end where()

    /**
     * Sets the where_in portion of the query in a chainable format.
     *
     * @param string  $field The field to search the db on.
     * @param array  $value The value to match the field against.
     */
    public function where_in($field=FALSE, $value=FALSE)
    {
        if (!empty($field))
        {
            $this->db->where_in($field, $value);
        }

        return $this;

    }//end where()


    /**
     * Inserts a chainable order_by method from either a string or an
     * array of field/order combinations. If the $field value is an array,
     * it should look like:
     *
     * array(
     *     'field1' => 'asc',
     *     'field2' => 'desc'
     * );
     *
     * @param string $field The field to order the results by.
     * @param string $order Which direction to order the results ('asc' or 'desc')
     *
     */
    public function order_by($field=FALSE)
    {
        if (!empty($field))
        {
            if (is_string($field))
            {
                $this->db->order_by($field);
            }
            else if (is_array($field))
            {
                foreach ($field as $f => $o)
                {
                    $this->db->order_by($f, $o);
                }
            }
        }

        return $this;

    }//end order_by()

    /**
     * A utility function to allow child models to use the type of
     * date/time format that they prefer. This is primarily used for
     * setting created_on and modified_on values, but can be used by
     * inheriting classes.
     *
     * The available time formats are:
     * * 'int'      - Stores the date as an integer timestamp.
     * * 'datetime' - Stores the date and time in the SQL datetime format.
     * * 'date'     - Stores teh date (only) in the SQL date format.
     *
     * @param mixed $user_date An optional PHP timestamp to be converted.
     *
     * @access protected
     *
     * @return int|null|string The current/user time converted to the proper format.
     */
    public function set_date($user_date=NULL)
    {
        $curr_date = !empty($user_date) ? $user_date : time();

        switch ($this->_date_format)
        {
            case 'int':
                return $curr_date;
                break;
            case 'datetime':
                return date('Y-m-d H:i:s', $curr_date);
                break;
            case 'date':
                return date( 'Y-m-d', $curr_date);
                break;
        }

    }//end set_date()

    //---------------------------------------------------------------
}