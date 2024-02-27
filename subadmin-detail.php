<?php include("header.php"); ?>
<?php print_r($_REQUEST); ?>
<div class="mb-2 h4">ข้อมูลโรงเรียนที่เป็นตัวแทน</div>
<form method="post" action="" autocomplete="off">
    <div class="form-row">
        <div class="form-group col-md-12">
            <label for="schoolname">ชื่อสถานศึกษา</label>
            <input type="text" class="form-control" id="schoolname" name="schoolname">
        </div>
    </div>
    <div class="form-row">
    <div class="form-group col-md-12">
    <b class="mb-2 h5">ข้อมูลผู้เพิ่มผู้แข่งขัน</b>
</div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="fname">ชื่อ</label>
            <input type="text" class="form-control" id="fname" name="fname">
        </div>
        <div class="form-group col-md-6">
            <label for="lname">สกุล</label>
            <input type="text" class="form-control" id="lname" name="lname">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="tel">หมายเลขโทรศัพท์</label>
            <input type="text" class="form-control" id="tel" name="tel">
        </div>
        <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" placeholder="Email" name="email">
        </div>
        <div class="form-group col-md-6">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" autocomplete="new-password">
        </div>
        <div class="form-group col-md-6">
            <label for="confpassword">Confirm Password</label>
            <input type="password" class="form-control" id="confpassword" name="confpassword" autocomplete="new-password">
        </div>
    </div>

    <button type="submit" class="btn btn-primary">บันทึก</button>
</form>
<?php include("footer.php"); ?>