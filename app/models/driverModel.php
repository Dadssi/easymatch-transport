<?php

require 'packageModel.php';



class DriverModel extends User{
    private $announcements = [];
    private $packages = [];



    public function __construct($announcements, $packages){

        $this->announcements = $announcements;
        $this->packages = $packages;
        $this->packages_delivered = $packages_delivered;
        $this->packages_ontheway = $packages_ontheway;
        $this->packages_pending = $packages_pending;
        $this->packages_cancelled = $packages_cancelled;
        $this->packages_accepted = $packages_accepted;

        loadAnnouncements();

    }

    public function loadAnnouncements(){
        $announcements = AnnouncementModel::getAnnouncements();
        foreach($announcements as $as){
            $announcement = new AnnouncementModel;
            $announcement->intilize($as['id']);
            $this->announcements[] = $announcement;
        }
    }

    public function loadPackages(){
        $Packages = PackageModel::getPackages();
        foreach($Packages as $as){
            $Package = new AnnouncementModel;
            $Package->intilize($as['id']);
            $this->packages[] = $Package;
        }
    }


}