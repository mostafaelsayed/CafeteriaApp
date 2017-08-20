<?php

function getRoles($conn)
{
  $sql = "select * from Role";
  $result = $conn->query($sql);
  if ($result)
  {
    $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
      return $roles;   
  }
  else
  {
    echo "Error retrieving Roles: " . $conn->error;
  }
}

function getRoleById($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: Role Id is not set";
    return;
  }
  else
  {
    $sql = "select * from Role where Id=".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $roles = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $roles;   
      
    }
    else
    {
      echo "Error retrieving Role: " . $conn->error;
    }
  }
}

function getRoleIdByName($conn,$name)
{
  if (!isset($name)) 
  {
    //echo "Error: Role Id is not set";
    return;
  }
  else
  {
    $name = mysqli_real_escape_string($conn , $name);
    $sql = "select `Id` from `Role` where `Name` = '{$name}' ";
    $result = $conn->query($sql);
    if ($result)
    {
      $roles = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $roles["Id"];   
      
    }
    else
    {
      echo "Error retrieving Role: " . $conn->error;
    }
  }
}

function getDirIdByRoleId($conn,$id,$backend=false)
{
  if (!isset($id)) 
  {
    //echo "Error: Role Id is not set";
    return;
  }
  else
  {
    $sql = "select DirId from Dir_Role where RoleId=".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $roles = mysqli_fetch_all($result, MYSQLI_ASSOC);
      mysqli_free_result($result);
        return $roles;   
      
    }
    else
    {
      echo "Error retrieving Dir Ids : " . $conn->error;
    }
  }
}

function getDirById($conn,$id)
{
  if (!isset($id)) 
  {
    //echo "Error: Role Id is not set";
    return;
  }
  else
  {
    $sql = "select Dir from Dir where Id=".$id." LIMIT 1";
    $result = $conn->query($sql);
    if ($result)
    {
      $roles = mysqli_fetch_assoc($result);
      mysqli_free_result($result);
        return $roles;   
      
    }
    else
    {
      echo "Error retrieving Dir Ids : " . $conn->error;
    }
  }
}

function addRole($conn,$name)
{
  if (!isset($name)) 
  {
    //echo "Error: Role name is not set";
    return;
  }
  else
  {
    $sql = "insert into Role (Name) values (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s",$Name);
    $Name = $name;
    if ($stmt->execute()===TRUE)
    {
      return "Role Added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function addDir($conn,$name,$path)
{
  if( !isset($name)) 
  {
   // echo "Error: Dir name is not set";
    return;
  }
  elseif (!isset($path)) 
  {
    //echo "Error: Dir path is not set";
    return;
  }
  else
  {
    $sql = "insert into Dir (Name,Dir) values (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss",$Name,$Path);
    $Name = $name;
    $Path = $path;
    if ($stmt->execute()===TRUE)
    {
      return "Dir name and path added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function addRoleForDir($conn,$roleId,$dirId)
{
  if (!isset($roleId))
  {
    //echo "Error: Role Id is not set";
    return;
  }
  elseif (!isset($dirId)) 
  {
    //echo "Error: Dir Id is not set";
    return;
  }
  else
  {
    $sql = "insert into Dir_Role (DirId,RoleId) values (?,?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii",$DirId,$RoleId);
    $DirId = $dirId;
    $RoleId = $roleId;
    if ($stmt->execute()===TRUE)
    {
      return "Role and Dir added successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function editRole($conn,$name,$id)
{
  if (!isset($name)) 
  {
    //echo "Error: Role name is not set";
    return;
  }
  elseif (!isset($id))
  {
   // echo "Error: Role id is not set";
    return;
  }
  else
  {
    $sql = "update Role set Name = (?) where Id = (?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si",$Name,$Id);
    $Name = $name;
    $Id = $id;
    if ($stmt->execute()===TRUE)
    {
      return "Role updated successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

function deleteRole($conn,$id) // cascaded delete ??
{ 
  if (!isset($id))
  {
    //echo "Error: Id is not set";
    return;
  }
  else
  {
    //$conn->query("set foreign_key_checks = 0"); // ????????/
    $sql = "delete from Role where Id = ".$id . " LIMIT 1";
    if ($conn->query($sql)===TRUE)
    {
      return "Role deleted successfully";
    }
    else
    {
      echo "Error: ".$conn->error;
    }
  }
}

?>