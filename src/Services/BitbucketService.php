<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Services;

use Gnello\WebhookManager\WebhookManagerException;

/**
 * Class BitbucketService
 *
 * @link https://confluence.atlassian.com/bitbucket/event-payloads-740262817.html
 * @package Gnello\WebhookManager\Services
 */
class BitbucketService implements ServiceInterface
{
    /**
     * Repository events
     */
    const PUSH = 'repo:push';
    const FORK = 'repo:fork';
    const UPDATED = 'repo:updated';
    const TRANSFER = 'repo:transfer';
    const COMMIT_COMMENT_CREATED = 'repo:commit_comment_created';
    const BUILD_STATUS_CREATED = 'repo:commit_status_created';
    const BUILD_STATUS_UPDATED = 'repo:commit_status_updated';

    /**
     * Issue events
     */
    const ISSUE_CREATED = 'issue:created';
    const ISSUE_UPDATD = 'issue:updated';
    const ISSUE_COMMENT_CREATED = 'issue:comment_created';

    /**
     * Pull request events
     */
    const PULL_REQUEST_CREATED = 'pullrequest:created';
    const PULL_REQUEST_UPDATED = 'pullrequest:updated';
    const PULL_REQUEST_APPROVED = 'pullrequest:approved';
    const PULL_REQUEST_APPROVAL_REMOVED = 'pullrequest:unapproved';
    const PULL_REQUEST_MERGED = 'pullrequest:fulfilled';
    const PULL_REQUEST_COMMENT_CREATED = 'pullrequest:comment_created';
    const PULL_REQUEST_COMMENT_UPDATED = 'pullrequest:comment_updated';
    const PULL_REQUEST_COMMENT_DELETED = 'pullrequest:comment_deleted';

    /**
     * @var array
     */
    private $options;

    /**
     * @var array
     */
    private $headers = [];

    /**
     * @var mixed
     */
    private $payload;

    /**
     * BitbucketService constructor.
     *
     * @param array $options
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @return array
     */
    public function getHeaders(): array
    {
        $this->headers['X-Event-Key'] = $_SERVER['HTTP_X_EVENT_KEY'];
        $this->headers['X-Hook-UUID'] = $_SERVER['HTTP_X_HOOK_UUID'];
        $this->headers['X-Request-UUID'] = $_SERVER['HTTP_X_REQUEST_UUID'];
        $this->headers['X-Attempt-Number'] = $_SERVER['HTTP_X_ATTEMPT_NUMBER'];

        return $this->headers;
    }

    /**
     * @return string
     * @throws WebhookManagerException
     */
    public function getEvent(): string
    {
        if (empty($this->headers)) {
            $this->getHeaders();
        }

        if (!isset($this->headers['X-Event-Key'])) {
            throw new WebhookManagerException("No event specified.");
        }

        return $this->headers['X-Event-Key'];
    }

    /**
     * @return mixed
     */
    public function getPayload()
    {
        if (!isset($this->payload)) {
            $this->payload = json_decode(file_get_contents('php://input'), (bool) $this->options['json_decode_assoc']);
        }

        return $this->payload;
    }
}