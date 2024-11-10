<?php
include ('components/header.php');
$userId = $user['acc_id'];
$accCode = $user['acc_code'];
$customerFullname = $user['acc_fname']." ".$user["acc_lname"];
$customerEmail = $user["acc_email"];
$customerPhone = $user["acc_contact"];

$birthdate = new DateTime($user['acc_birthday']);
$today = new DateTime('today');
$age = $birthdate->diff($today)->y;

$getAddress = $db->getUserAddress2($accCode);
$fullAddress = 'No Address Set';
if ($getAddress->num_rows > 0) {
    $address = $getAddress->fetch_assoc();
    $fullAddress = $address['user_complete_address'];
}
?>

<style>
        body {
            background-color: #e9ecef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .profile-card {
            max-width: 700px;
            margin: 50px auto;
            background: linear-gradient(135deg, #ffffff, #f8f9fa);
            border-radius: 15px;
            box-shadow: 0px 8px 30px rgba(0, 0, 0, 0.15);
            padding: 40px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .profile-card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 12px 40px rgba(0, 0, 0, 0.2);
        }

        .profile-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin-bottom: 20px;
            object-fit: cover;
            border: 6px solid #007bff;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.1);
        }

        .profile-info {
            text-align: center;
        }

        .profile-info h2 {
            margin-bottom: 10px;
            font-weight: 700;
            color: #343a40;
            text-transform: uppercase;
        }

        .profile-info h6 {
            color: #6c757d;
            margin-bottom: 20px;
            font-style: italic;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            font-size: 0.9rem;
        }

        .form-control {
            border: 2px solid #dee2e6;
            border-radius: 10px;
            transition: border-color 0.3s;
        }

        .form-control:focus {
            border-color: #007bff;
            box-shadow: none;
        }

        .btn-group-custom {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 30px;
        }

        .btn-group-custom .btn {
            padding: 12px 25px;
            font-size: 16px;
            font-weight: 500;
            border-radius: 30px;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-group-custom .btn:hover {
            transform: translateY(-2px);
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #117a8b;
            border-color: #10707f;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .profile-info h6 span {
            font-weight: 600;
            color: #007bff;
        }

    </style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css" />

<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>



    <!-- Updated By: Zyrine Alcarez 08/28/24 -->
<div class="profile-card">
    <div class="profile-info text-center">
    <img alt="Profile Image" class="profile-img" src="<?= ($user['emp_image'] != '') ? '../upload_img/' . $user['emp_image'] : 'assets/img/no-img-available.png' ?>">
        <h2><?= $user['acc_fname'] . ' ' . $user['acc_lname'] ?></h2>
        <h6>Age: <span><?= $age ?></span></h6>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" readonly value="<?= $user['acc_username'] ?>">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" readonly value="<?= $user['acc_email'] ?>">
            </div>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-sm-6">
            <div class="form-group">
                <label for="contact">Contact #</label>
                <input type="text" class="form-control" id="contact" readonly value="<?= $user['acc_contact'] ?>">
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" rows="3" readonly><?= $fullAddress ?></textarea>
            </div>
        </div>
    </div>
    <div class="btn-group-custom">
        


        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalUpdateChoices">
            Update Information
        </button>
    </div>
</div>

<div class="modal fade" id="modalUpdateChoices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-bs-backdrop="false">
  <div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="profileModalLabel">Edit Profile</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
            <div class="d-grid gap-2">
                <button class="btn btn-dark" id="btnEditProfile" 
                    data-fname="<?= $user['acc_fname'] ?>" 
                    data-lname="<?= $user['acc_lname'] ?>" 
                    data-bday="<?= $user['acc_birthday'] ?>" 
                    data-uname="<?= $user['acc_username'] ?>" 
                    data-email="<?= $user['acc_email'] ?>" 
                    data-contact="<?= $user['acc_contact'] ?>">
                    Edit Information
                </button>
                <button class="btn btn-primary btnEditAddress">Edit Address</button>
                <button class="btn btn-secondary" id="btnProfileImgModal">Edit Image</button>
                <button class="btn btn-success" id="btnEditPassword" >Change Password</button>
            </div>
        </div>
    </div>
  </div>
</div>

<?php
include ('components/footer.php');
?>