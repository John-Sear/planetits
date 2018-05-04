<?php
/**
 * Dev Room Two Class
 * #jff
 */

/** Class DevRoomTwo */
class DevRoomTwo
{
    /**
     * @var array $_trigger
     * @var array $_actions
     * @var array $_realSeniors
     */
    private $_trigger, $_actions, $_realSeniors;

    /**
     * DevRoomTwo constructor.
     * @param array $realSeniorsArray
     */
    public function __construct(array $realSeniorsArray)
    {
        foreach($realSeniorsArray as $realSenior) {
            $this->_addRealSenior($realSenior);
        }
    }

    /**
     * Add Real Seniors, with Error Handling!
     *
     * @param string $realSenior
     */
    private function _addRealSenior($realSenior) {
        if($realSenior === '******') { trigger_error('NOT A REAL SENIOR: "' . $realSenior . '"!', E_USER_ERROR); }

        $realSeniors = is_array($this->_realSeniors) ? $this->_realSeniors : array();

        $realSeniors[] = $realSenior;

        $this->_realSeniors = $realSeniors;
    }

    /**
     * Add Trigger to a real Senior
     *
     * @param string $realSenior
     * @param string $trigger
     */
    public function addTrigger($realSenior, $trigger) {
        $triggerArray = is_array($this->_trigger) ? $this->_trigger : array();
        $realSeniors = is_array($this->_realSeniors) ? $this->_realSeniors : array();

        if(in_array($realSenior, $realSeniors, true)) {
            $triggerArray[$realSenior][] = $trigger;
            $triggerArrayUnique = array_unique($triggerArray[$realSenior]);

            $this->_trigger = $triggerArrayUnique;
        }
    }

    /**
     * Add Action to Trigger
     *
     * @param string $trigger
     * @param string $action
     */
    public function addAction($trigger, $action) {
        $triggerArray = is_array($this->_trigger) ? $this->_trigger : array();
        $actionArray = is_array($this->_actions) ? $this->_actions : array();

        if(in_array($trigger, $triggerArray, true)) {
            $actionArray[$trigger] = $action;

            $this->_actions = $actionArray;
        }
    }

    /**
     * Executing a trigger
     *
     * @param string $trigger
     * @return string
     */
    public function execute($trigger) {
        $return = '';
        $triggerArray = is_array($this->_trigger) ? $this->_trigger : array();
        $actionArray = is_array($this->_actions) ? $this->_actions : array();

        if(in_array($trigger, $actionArray, true)) {
            $action = $actionArray[$trigger];

            $executedSeniors = array();

            foreach($triggerArray as $realSenior => $rsTriggerArray) {
                if(in_array($trigger, $rsTriggerArray, true)) {
                    $executedSeniors[] = $realSenior;
                }
            }

            if(count($executedSeniors)) {
                if(count($executedSeniors) > 1){
                    $executedSeniorsString = implode(' and ', $executedSeniors);
                    $return = $executedSeniorsString . ' saying "' . $action . '" simultaneously...';
                } else {
                    $executedSenior = reset($executedSeniors);
                    $return = $executedSenior . ' says "' . $action . '" immediately...';
                }
            }
        }

        return $return;
    }
}
