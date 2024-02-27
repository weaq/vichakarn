<nav id="sidebar">
    <div class="custom-menu">
        <button type="button" id="sidebarCollapse" class="btn btn-primary">
            <i class="fa fa-bars"></i>
            <span class="sr-only">Menu</span>
        </button>
    </div>
    <div class="p-4 pt-5">
        <h1><a href="index.php" class="h3 text-white">งานวิชาการ</a></h1>
        <div>
            <?php
            echo $_SESSION['sess_user'];
            ?>
        </div>
        <ul class="list-unstyled components mb-5">
            <li class="active">
                <a href="#pageSubmenu1" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">จัดการข้อมูล</a>
                <ul class="collapse list-unstyled" id="pageSubmenu1">
                    <li>
                        <a href="admin-detail.php">ข้อมูลพื้นฐาน อปท.</a>
                    </li>
                    <li>
                        <a href="activity-list.php">รายการแข่งขันทักษะวิชาการ</a>
                    </li>
                    <li>
                        <a href="#">โรงเรียนที่เป็นตัวแทน</a>
                    </li>
                    <li>
                        <a href="select-activity.php">กิจกรรมแต่ละโรงเรียน</a>
                    </li>
                    
                    <li>
                        <a href="#">พิมพ์รายชื่อโรงเรียนทั้งหมด</a>
                    </li>
                    <li>
                        <a href="#">พิมพ์ชื่อผู้ใช้และรหัสผ่าน</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu2" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">ตรวจสอบข้อมูล</a>
                <ul class="collapse list-unstyled" id="pageSubmenu2">
                    <li>
                        <a href="#">รายชื่อ ร.ร. ที่ลงทะเบียนไม่ครบ</a>
                    </li>
                    <li>
                        <a href="#">ความครบถ้วนของจำนวนนักเรียน</a>
                    </li>
                    <li>
                        <a href="#">รายการที่ส่งมากกว่า 1 โรงเรียน</a>
                    </li>
                    <li>
                        <a href="#">สรุปผลการลงทะเบียน</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#pageSubmenu3" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle">สรุปข้อมูล</a>
                <ul class="collapse list-unstyled" id="pageSubmenu3">
                    <li>
                        <a href="#">ผลการแข่งขัน</a>
                    </li>
                    <li>
                        <a href="#">จำนวนนักเรียนที่เป็นตัวแทน</a>
                    </li>
                    <li>
                        <a href="#">สรุปอันดับรางวัล</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="logout.php">ออกจากระบบ</a>
            </li>
        </ul>
        <!--
        <div class="mb-5">
            <h3 class="h6">Subscribe for newsletter</h3>
            <form action="#" class="colorlib-subscribe-form">
                <div class="form-group d-flex">
                    <div class="icon"><span class="icon-paper-plane"></span></div>
                    <input type="text" class="form-control" placeholder="Enter Email Address">
                </div>
            </form>
        </div>
-->
        <div class="footer">
            <p>
                Copyright &copy;<script>
                    document.write(new Date().getFullYear());
                </script> <br><i class="icon-heart" aria-hidden="true"></i> <a href="https://www.udoncity.go.th" target="_blank" class="text-light">เทศบาลนครอุดรธานี</a>
            </p>
        </div>
    </div>
</nav>