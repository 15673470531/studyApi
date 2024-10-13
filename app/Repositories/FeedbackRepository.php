<?php

namespace App\Repositories;

use App\Models\Feedback;

class FeedbackRepository {

    private $feedbackMd;
    public function __construct() {
        $this->feedbackMd = Feedback::query();
    }

    public function createMessage(int $userid, string $content): bool {
        return $this->feedbackMd->insert([
            'uid' => $userid,
            'content' => $content,
        ]);
    }
}
