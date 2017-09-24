<?php

/**
 * WebhookManager
 *
 * @author: Luca Agnello <luca@gnello.com>
 */

namespace Gnello\WebhookManager\Services;

use Gnello\WebhookManager\WebhookManagerException;

/**
 * Class GithubService
 *
 * @link https://developer.github.com/v3/activity/events/types
 * @package Gnello\WebhookManager\Services
 */
class GithubService implements ServiceInterface
{
    /**
     * General events
     */
    const ALL = '*';
    const LABEL = 'label';
    const MARKETPLACE_PURCHASE = 'marketplace_purchase';
    const MEMBER = 'member';
    const MEMBERSHIP = 'membership';
    const MILESTONE = 'milestone';
    const ORGANIZATION = 'organization';
    const ORG_BLOCK = 'org_block';
    const PAGE_BUILD = 'page_build';
    const PUBLIC = 'public';
    const WATCH = 'watch';

    /**
     * Repository events
     */
    const COMMIT_COMMENT = 'commit_comment';
    const CREATE = 'create';
    const DELETE = 'delete';
    const DEPLOYMENT = 'deployment';
    const DEPLOYMENT_STATUS = 'deployment_status';
    const FORK = 'fork';
    const GOLLUM = 'gollum';
    const INSTALLATION = 'installation';
    const INSTALLATION_REPOSITORIES = 'installation_repositories';
    const PUSH = 'push';
    const REPOSITORY = 'repository';
    const RELEASE = 'release';
    const STATUS = 'status';

    /**
     * Issue events
     */
    const ISSUE_COMMENT = 'issue_comment';
    const ISSUES = 'issues';

    /**
     * Pull request events
     */
    const PULL_REQUEST_REVIEW_COMMENT = 'pull_request_review_comment';
    const PULL_REQUEST_REVIEW = 'pull_request_review';
    const PULL_REQUEST = 'pull_request';

    /**
     * Team events
     */
    const TEAM = 'team';
    const TEAM_ADD = 'team_add';

    /**
     * Project events
     */
    const PROJECT_CARD = 'project_card';
    const PROJECT_COLUMN = 'project_column';
    const PROJECT = 'project';

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
        $this->headers['X-GitHub-Event'] = $_SERVER['HTTP_X_GITHUB_EVENT'];
        $this->headers['X-GitHub-Delivery'] = $_SERVER['HTTP_X_GITHUB_DELIVERY'];

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

        if (!isset($this->headers['X-GitHub-Event'])) {
            throw new WebhookManagerException("No event specified.");
        }

        return $this->headers['X-GitHub-Event'];
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