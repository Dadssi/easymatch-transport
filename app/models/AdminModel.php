<?php


class AdminModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function deleteAnnouncement($announcement_id) {
        try {
            $this->db->beginTransaction();
            
            
            $stmt = $this->db->prepare("DELETE FROM announcement_cities WHERE announcement_id = :id");
            $stmt->execute([':id' => $announcement_id]);
            
            
            $stmt2 = $this->db->prepare("DELETE FROM driver_announcements WHERE announcement_id = :id");
            $stmt2->execute([':id' => $announcement_id]);
            
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw new Exception("Failed to delete announcement: " . $e->getMessage());
        }
    }

    public function deleteUser($user_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM users WHERE user_id = :id");
            return $stmt->execute([':id' => $user_id]);
        } catch (Exception $e) {
            throw new Exception("Failed to delete user: " . $e->getMessage());
        }
    }

    public function deletePackage($package_id) {
        try {
            $stmt = $this->db->prepare("DELETE FROM sender_requests WHERE request_id = :id");
            return $stmt->execute([':id' => $package_id]);
        } catch (Exception $e) {
            throw new Exception("Failed to delete package: " . $e->getMessage());
        }
    }

    public function getStats() {
        $stats = [];

        // Users stats
        $stmt = $this->db->query("SELECT COUNT(*) as total_users FROM users");
        $total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total_users'];

        $stmt = $this->db->query("SELECT COUNT(*) as total_drivers FROM users WHERE role = 'driver'");
        $total_drivers = $stmt->fetch(PDO::FETCH_ASSOC)['total_drivers'];

        $stmt = $this->db->query("SELECT COUNT(*) as verified_drivers FROM users WHERE role = 'driver' AND isverified = true");
        $verified_drivers = $stmt->fetch(PDO::FETCH_ASSOC)['verified_drivers'];

        $stmt = $this->db->query("SELECT COUNT(*) as total_senders FROM users WHERE role = 'sender'");
        $total_senders = $stmt->fetch(PDO::FETCH_ASSOC)['total_senders'];

        $users_stats = [
            'total_users' => (int)$total_users,
            'drivers' => [
                'total'      => (int)$total_drivers,
                'verified'   => (int)$verified_drivers,
                'unverified' => (int)$total_drivers - (int)$verified_drivers,
            ],
            'senders' => [
                'total' => (int)$total_senders,
            ]
        ];

       
        $stmt = $this->db->query("SELECT COUNT(*) as total_packages FROM sender_requests");
        $total_packages = $stmt->fetch(PDO::FETCH_ASSOC)['total_packages'];

        $stmt = $this->db->query("SELECT status, COUNT(*) as count FROM sender_requests GROUP BY status");
        $packages_by_status = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $packages_by_status[$row['status']] = (int)$row['count'];
        }

        $packages_stats = [
            'total_packages' => (int)$total_packages,
            'by_status'      => $packages_by_status
        ];

        // Announcements stats
        $stmt = $this->db->query("SELECT COUNT(*) as total_announcements FROM driver_announcements");
        $total_announcements = $stmt->fetch(PDO::FETCH_ASSOC)['total_announcements'];

        $stmt = $this->db->query("SELECT vehicle_type, COUNT(*) as count FROM driver_announcements GROUP BY vehicle_type");
        $announcements_by_vehicle = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $announcements_by_vehicle[$row['vehicle_type']] = (int)$row['count'];
        }

        $announcements_stats = [
            'total_announcements' => (int)$total_announcements,
            'by_vehicle_type'     => $announcements_by_vehicle
        ];

        $stats['users']         = $users_stats;
        $stats['packages']      = $packages_stats;
        $stats['announcements'] = $announcements_stats;

        return $stats;
    }

    public function verifyDriver($driver_id) {
        try {
            $stmt = $this->db->prepare("UPDATE users SET isverified = TRUE WHERE user_id = :id AND role = 'driver'");
            return $stmt->execute([':id' => $driver_id]);
        } catch (Exception $e) {
            throw new Exception("Failed to verify driver: " . $e->getMessage());
        }
    }

    public function getAllUsers(){
        try {
            $stmt = $this->db->prepare("select * from users");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            throw new Exception("Failed to load All Users: " . $e->getMessage());
        }
    }
}





