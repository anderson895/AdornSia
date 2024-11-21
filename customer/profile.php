<?php
include "component/header.php";


$fetch_user_info = $db->fetch_user_info($userID); 
foreach ($fetch_user_info as $user):
    $user_fullname=$user['Fullname'];
    $user_email=$user['Email'];
    $user_phone=$user['Phone'];
    $user_profileImages=$user['Profile_images'];
    
endforeach;
?>

<div class="max-w-4xl mx-auto p-8 bg-white shadow-xl rounded-lg mt-8">
  <h2 class="text-4xl font-semibold mb-6 text-gray-900">My Profile</h2>
  <p class="text-lg text-gray-600 mb-8">Manage and protect your account</p>
  
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
    <!-- Left section -->
    <div>
<form id="userProfileFrm">
    <input hidden type="text" name="requestType" value="UpdateUserProfile">
    <input hidden type="text" name="userID" value="<?=$userID?>">
      <label class="block text-sm font-medium text-gray-700 mt-4">Name</label>
      <input type="text" name="user_fullname" value="<?=$user_fullname?>" class="mt-2 bg-gray-100 p-4 w-full border border-gray-300 rounded-md focus:ring-2 focus:ring-gray-500 focus:border-orange-500 transition ease-in-out">

      <label class="block text-sm font-medium text-gray-700 mt-6">Email</label>
      <div class="flex items-center border-b border-gray-300 pb-2">
        <input type="email" name="user_email" value="<?=$user_email?>" class="mt-2 p-4 w-full bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-gray-500 focus:border-orange-500 transition ease-in-out">
      </div>
      
      <label class="block text-sm font-medium text-gray-700 mt-6">Phone Number</label>
      <div class="flex items-center border-b border-gray-300 pb-2">
        <input type="text" name="user_phone" value="<?=$user_phone?>" class="mt-2 p-4 w-full bg-gray-100 border-0 rounded-md focus:ring-2 focus:ring-gray-500 focus:border-orange-500 transition ease-in-out" >
      </div>
    </div>

    <!-- Right section (Image upload) -->
    <div class="flex flex-col justify-between">
      <div class="text-center">
        <label for="profile-image" class="block text-sm font-medium text-gray-700">Profile Image</label>
        <!-- Default Image or Uploaded Image -->
        <div class="mb-4">
        <img id="preview-image" 
     src="../upload/<?php echo $user_profileImages !== null ? $user_profileImages : 'data:image/svg+xml,%3Csvg%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20class%3D%22inline-block%20h-6%20w-6%22%3E%3Cpath%20d%3D%22M21.649%2019.875c-1.428-2.468-3.628-4.239-6.196-5.078a6.75%206.75%200%2010-6.906%200c-2.568.839-4.768%202.609-6.196%205.078a.75.75%200%20101.299.75C5.416%2017.573%208.538%2015.75%2012%2015.75c3.462%200%206.584%201.823%208.35%204.875a.751.751%200%20101.299-.75zM6.75%209a5.25%205.25%200%201110.5%200%205.25%205.25%200%2001-10.5%200z%22%20fill%3D%22%23000%22%20class%3D%22fill-grey-100%22%3E%3C%2Fpath%3E%3C%2Fsvg%3E'; ?>" 
     alt="Profile Image" 
     class="w-32 h-32 rounded-full mx-auto object-cover">

        </div>

        <!-- Image Upload Input -->
        <input type="file" id="profileimage" name="profileimage" class="hidden" accept="image/*" onchange="previewImage(event)">
        <label for="profileimage" class="mt-2 inline-block text-blue-500 hover:text-blue-700 transition ease-in-out cursor-pointer">Upload Image</label>
      </div>
    </div>
  </div>

  <div class="mt-8 flex justify-end">
    <button type="submit" class="btnUpdateProfile bg-orange-500 text-white py-3 px-8 rounded-lg hover:bg-orange-600 transition ease-in-out text-lg font-medium">Save</button>
  </div>
</form>
</div>

<?php include "component/footer.php"; ?>


<script>


// Preview image function
function previewImage(event) {
  const file = event.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      const img = document.getElementById('preview-image');
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
}
</script>