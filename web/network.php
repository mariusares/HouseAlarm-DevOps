<?php
if (!isset($_SESSION)) {
    session_start();
}
include "dbconnect.php";
include "header.php";
if (!isset($_SESSION["id"])) {
    header("Location: login.php");
}
if (isset($_POST["btn-network"])) {
    $connection = $_POST["connection"];
    $network    = $_POST["network"];
    $npassword  = $_POST["npassword"];
    if ($connection == "wifi") {
        //shell_exec("sudo timedatectl set-timezone $timezone");
        //echo "<script type='text/javascript'> document.location = 'index.php'; </script>";
        $wifiConfig = "/etc/wpa_supplicant/wpa_supplicant.conf";
        $configData =
            "country=IE\nctrl_interface=DIR=/var/run/wpa_supplicant GROUP=netdev\nupdate_config=1\nnetwork={\n\tssid=\"" .
            $network .
            "\"\n\tpsk=\"" .
            $npassword .
            "\"\n}";
        ($file1 = fopen($wifiConfig, "w")) or die("can't open file");
        fwrite($file1, $configData);
        fclose($file1);
        $networkConfig = "/etc/network/interfaces";
        $writeFile     =
            "auto wlan0\nallow-hotplug wlan0\niface wlan0 inet dhcp\n    wpa-conf /etc/wpa_supplicant/wpa_supplicant.conf";
        ($file2 = fopen($networkConfig, "w")) or die("can't open file");
        fwrite($file2, $writeFile);
        fclose($file2);
        shell_exec(
            "sudo  /bin/systemctl disable dnsmasq  >> /dev/null 2>&1 && sudo /bin/systemctl disable hostapd  >> /dev/null 2>&1 && sudo /sbin/reboot  >> /dev/null 2>&1"
        );
    } else {
        $wifiConfig = "/etc/hostapd/hostapd.conf";
        $configData =
            "ssid=" .
            $network .
            "\nwpa_passphrase=" .
            $npassword .
            "\ninterface=wlan0\ndriver=nl80211\nhw_mode=g\nchannel=7\nwmm_enabled=0\nmacaddr_acl=0\nauth_algs=1\nignore_broadcast_ssid=0\nwpa=2\nwpa_key_mgmt=WPA-PSK\nwpa_pairwise=TKIP\nrsn_pairwise=CCMP\n";
        ($file1 = fopen($wifiConfig, "w")) or die("can't open file");
        fwrite($file1, $configData);
        fclose($file1);
        $networkConfig = "/etc/network/interfaces";
        $writeFile     =
            "allow-hotplug wlan0\niface wlan0 inet static\n    address 192.168.4.1\n    netmask 255.255.255.0\n    gateway 192.168.4.1\n    dns-nameservers 192.168.4.1\n    nohook wpa_supplicant";
        ($file2 = fopen($networkConfig, "w")) or die("can't open file");
        fwrite($file2, $writeFile);
        fclose($file2);
        shell_exec(
            "sudo  /bin/systemctl enable dnsmasq  >> /dev/null 2>&1 && sudo /bin/systemctl enable hostapd  >> /dev/null 2>&1 && sudo /sbin/reboot  >> /dev/null 2>&1"
        );
    }
}
?>
<div class="d-inline d-none d-sm-block">
    <div class="pt-5">
    </div>
</div>
<div class="container bg-light border border-2 border-success rounded-start rounded-end"
    style="max-width: 900px; padding: 15px; min-width: 100px !important;">
    <h4 class="text-center text-white text-solid bg-success">Network Setup</h4>
    <form class="form p-4" id="timezone" method="post" role="form">
        <div class="row g-1">
            <div class="col-6">
                <h6>Connection type: </h6>
            </div>
            <div class="col-6">
                <select class="form-control" name="connection" required>
                    <option value="wifi">Wifi</option>
                    <option value="ap">Access Point(AP)</option>
                </select>
            </div>
            <div class="col-6">
                <h6>Network name: </h6>
            </div>
            <div class="col-6">
                <input type="text" class="form-control" name="network" autocomplete="off" placeholder="Wifi Network"
                    required>
            </div>
            <div class="col-6">
                <h6>Network password: </h6>
            </div>
            <div class="col-6">
                <input type="password" class="form-control" name="npassword" autocomplete="off" required>
            </div>
        </div>
        </p>
        <div class="d-flex align-items-end justify-content-end ">
            <button class="btn btn-success" type="submit" name="btn-network">Submit</button>
        </div>
</div>
</div>
</form>

<?php
include 'footer.php';
?>