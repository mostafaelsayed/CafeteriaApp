<?php

function getLanguages($conn,$backend=false)
{
  $sql = "select * from Languages ";
  $result = $conn->query($sql);
  if ($result)
  {
    $languages = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    if ($backend)
    { 
      return $languages;   
    }
    else
    {
      $languages = json_encode($languages);

      echo $languages;
    }  
  }
  else
  {
    echo "Error retrieving Languages: " . $conn->error;
  }
}


function addLanguage($conn,$name)
{
  $sql = "insert into Languages (Name) values (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s",$Name);
  $Name = $name;
  if ($stmt->execute()===TRUE)
  {
    echo "Language Added successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function editLanguage($conn,$name,$id)
{
  $sql = "update Languages set Name = (?) , where Id = (?)";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("si",$Name,$Id);
  $Name = $name;
  $Id = $id;
  if ($stmt->execute()===TRUE)
  {
    echo "Language updated successfully";
  }
  else
  {
    echo "Error: ".$conn->error;
  }
}

function deleteLanguage($conn,$id) // drop the colun also ???????
{
  if (!isset($id))
  {
    echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Languages where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      echo "Language deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>
