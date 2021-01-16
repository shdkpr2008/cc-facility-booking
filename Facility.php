<?php
    /// ToDo : Type Checking
    
    namespace Facilities;

    interface FacilityInterFace {
        public function getName();
        public function getType();
        public function getRate();
        public function setName($name);
        public function setType($type);
        public function setRate($rate);
    } 

    class Facility implements FacilityInterFace {
        private $name;
        private $type;
        private $rate;

        public function __construct($name, $type, $rate){
            $this->name = $name;
            $this->type = $type;
            $this->rate = $rate;
        }

        public function getName() {
            return $this->name;
        }

        public function getType() {
            return $this->type;
        }

        public function getRate() {
            return $this->rate;
        }

        public function setName($name) {
            $this->name = $name;
        }

        public function setType($type) {
            $this->type = $type;
        }

        public function setRate($rate) {
            $this->rate = $rate;
        }

    }
?>