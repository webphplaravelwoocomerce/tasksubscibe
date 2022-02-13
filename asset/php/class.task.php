<?php 

require "../../vendor/autoload.php";
use League\Csv\Writer;

class Subscribe {

        public $mysqli = '';

        public $data = '';

        public $object = '';

        public $name ='';
        public $email = '';


        /**
         * Connection 
         */

        public function __construct()
        {
                $this->mysqli = new mysqli('localhost', 'root','','task');

                if( $this->mysqli->connect_error){
                                
                        echo "Connection Error" . $this->mysqli->connect_error;
                }

        }

                /**
                 * Get json data and convert to php object
                 *
                 * 
                 */
        public function jsonData(){

                $this->data = file_get_contents("php://input");
                $this->object = json_decode($this->data);

                $this->name =  $this->object->fname;
                $this->email =  $this->object->email;
        

        }


        /**
         *username and email insert  into database and create record *in customer.csv file

         *method insert() will be called in the method formData()
         * 
         */
        public function insert(){

                $sql1 = "INSERT INTO subscribe (name, email)VALUES(?, ?)";

                $stmt1 = $this->mysqli->prepare($sql1);

                $stmt1->bind_param('ss',$this->name, $this->email);

                  if($stmt1->execute()){

                          echo "<p class=\"alert alert-green\">Exciting news comming soon !!</p>";

                          $writer = Writer::createFromPath('../../customer.csv', 'a');
                          $writer->insertOne([$this->name, $this->email]);

                  }else{

                          echo "<p class=\"alert alert-danger\">Try again!!</p>";

                  }
        

        }


        /**
         * Check if email exists .
         * If user exist, display message
         *  If email doesn't exist. Call method insert()
         *
         * 
         */
        public function formData() {

                $this->jsonData();
                
                $sql = "SELECT * FROM subscribe where email = ? ";

                $stmt = $this->mysqli->prepare($sql);
                $stmt->bind_param('s', $this->email);
                $stmt->execute();
                $stmt->store_result();
              
               if($stmt->num_rows){

                       echo "<p class=\"alert alert-danger\">Please, check your data!</p>";

               }else{
                      $this->insert();

               }

        }


} //class end

 $task = new Subscribe();
$task->formData();
?>