<style>
    .avatar {
        vertical-align: middle;
        border-radius: 50%;
    }

    .checked {
        color: orange;
    }
</style>

<div class="border-end bg-white" id="sidebar-wrapper">
    <div class="sidebar-heading border-bottom bg-primary text-white">BKEEPER</div>
    <center>
        <div class="rounded">
            <img src="profile_pictures/<?php echo $_SESSION['profile_picture'] ?>" width="200px" height="200px" alt="Avatar" class="avatar my-3">
        </div>
    </center>
    <div class="list-group list-group-flush">
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-my-bkeepers.php"><i class="fa fa-users"></i> My BKeepers</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-find-bkeepers.php"><i class="fa fa-search"></i> Find BKeepers</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-documents.php"><i class="fa fa-file"></i> Documents</a>
        <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-applicants.php"><i class="fa fa-user-plus"></i> Applicants</a>
        <!-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="admin-post-hiring.php"><i class="fa fa-users"></i> Post Hiring</a> -->
    </div>
</div>