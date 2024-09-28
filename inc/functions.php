<?php
define( 'DB_NAME', 'C:/xampp/htdocs/php_program/crud/data/db.txt' );
function seed($filename) {
    $data           = array(
        array(
            'id'    => 1,
            'fname' => 'Kamal',
            'lname' => 'Ahmed',
            'roll'  => '11'
        ),
        array(
            'id'    => 2,
            'fname' => 'Jamal',
            'lname' => 'Ahmed',
            'roll'  => '12'
        ),
        array(
            'id'    => 3,
            'fname' => 'Ripon',
            'lname' => 'Ahmed',
            'roll'  => '9'
        ),
        array(
            'id'    => 4,
            'fname' => 'Nikhil',
            'lname' => 'Chandra',
            'roll'  => '8'
        ),
        array(
            'id'    => 5,
            'fname' => 'John',
            'lname' => 'Rozario',
            'roll'  => '7'
        ),
    );
    $serializedData = serialize( $data );
    file_put_contents( $filename, $serializedData, LOCK_EX );
}


 function generateReport() {
    $serializedData = file_get_contents( DB_NAME );
    $students       = unserialize( $serializedData );
    ?>
      <table>
         <tr>
             <th>Name</th>
             <th>Roll</th>
             <th width="25%">Action</th>
         </tr>
         <?php
        
        foreach ($students as $student) {
            if (is_array($student)) {
                ?>
                <tr>
                    <td><?php printf('%s %s', $student['fname'], $student['lname']); ?></td>
                    <td><?php printf('%s', $student['roll']); ?></td>
                    <td><?php printf('<a href="/php_program/crud/index.php?task=edit&id=%s">Edit</a> | <a href="/php_program/crud/index.php?task=delete&id=%s">Delete</a>', $student['id'], $student['id']); ?></td>
                </tr>
                <?php
            } else {
                echo "<tr><td colspan='3'>Invalid student data.</td></tr>";
            }
        }
        ?> 

     </table>
     <?php 
 } 


 function addStudent($fname, $lname, $roll) {
    $found = false;
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);

    foreach($students as $_student){
        if($_student['roll'] == $roll){
            $found = true;
            break;
        }
    }
    if(!$found){
        $newId = count($students) + 1;
        $student = array(
            'id' => $newId,
            'fname' => $fname,
            'lname' => $lname,
            'roll' => $roll,
        );
    
        array_push($students, $student);
    
        $serializedData = serialize($students);
        file_put_contents(DB_NAME, $serializedData, LOCK_EX);
        return true;
    }
    return false;
}

function getStudent($id){
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);

    foreach($students as $student){
        if($student['id'] == $id){
            return $student;
        }
    }
    return false;
}

function updateStudent($id,$fname,$lname,$roll){
    $serializedData = file_get_contents(DB_NAME);
    $students = unserialize($serializedData);

    $students[$id-1]['fname'] = $fname;
    $students[$id-1]['lname'] = $lname;
    $students[$id-1]['roll'] = $roll;

    $serializedData = serialize($students);
    file_put_contents(DB_NAME, $serializedData, LOCK_EX);
    
}