<?php

namespace sollent\HealthCheckBundle\Service;

use sollent\HealthCheckBundle\Entity\HealthDataInterface;

interface HealthSenderInterface
{
    /**
     * @param HealthDataInterface[] $data
     */
    public function send(array $data): void;
    public function getDescription(): string;
    public function getName(): string;
}
