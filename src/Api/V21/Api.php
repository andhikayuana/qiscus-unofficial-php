<?php

namespace Yuana\Api\V21;

use GuzzleHttp\Client;
use Yuana\Api\BaseApi;

class Api extends BaseApi
{

    /**
     * @param array
     * *user_id* [string]
     * *password* [string password, optional] # if password is provided and user exists, the user's password will be updated
     * *username* [string]
     * *avatar_url* [string url, optional]
     * *extras* [JSONstring, optional] or valid JSON object
     */
    public function loginOrRegister(array $params)
    {
        return $this->post('/api/v2.1/rest/login_or_register', [
            'json' => $params
        ]);
    }

    /**
     * @param user_id
     */
    public function userProfile($userId)
    {
        return $this->get('/api/v2.1/rest/user_profile', [
            'query' => [
                'user_id' => $userId
            ]
        ]);
    }

    public function getUserToken($userId)
    {
        return $this->get('/api/v2.1/rest/get_user_token', [
            'query' => [
                'user_id' => $userId
            ]
        ]);
    }

    public function resetUserToken($userId)
    {
        return $this->post('/api/v2.1/rest/reset_user_token', [
            'json' => [
                'user_id' => $userId
            ]
        ]);
    }

    /**
     * *room_name* [string]
     * *participants*[] [array of string user_id]
     * *creator* [string user_id]
     * *room_avatar_url* [string] optional
     * *room_options* [JSON to string] optional
     */
    public function createRoom(array $params)
    {
        return $this->post('/api/v2.1/rest/create_room', [
            'json' => $params
        ]);
    }

    /**
     * *user_ids*[] [array of string] # must contains exactly 2 user_ids
     * *room_options* [JSON to string] optional
     */
    public function getOrCreateRoomWithTarget(array $params)
    {
        return $this->post('/api/v2.1/rest/get_or_create_room_with_target', [
            'json' => $params
        ]);
    }


    /**
     * *room_ids*[] [array of string]
     * *room_channel_ids*[] [array of string, optional]
     */
    public function getRoomsInfo(array $params)
    {
        return $this->post('/api/v2.1/rest/get_rooms_info', [
            'json' => $params
        ]);
    }

    /**
     * *room_id* [string required] must be group room
     * *room_channel_id* [string optional]
     * *room_name* [string optional]
     * *room_avatar_url* [string optional]
     * *room_options* [JSON to string optional]
     */
    public function updateRoom(array $params)
    {
        return $this->post('/api/v2.1/rest/update_room', [
            'json' => $params
        ]);
    }


    /**
     * *room_id* [string] # must contains valid "group" room
     * *page* [int] number of page, optional
     * *limit* [int] show n data, maximum and default value is 100
     */
    public function getRoomParticipants($roomId, $page = 1, $limit = 20)
    {
        return $this->get('/api/v2.1/rest/get_room_participants', [
            'query' => [
                'room_id' => $roomId,
                'page' => $page,
                'limit' => $limit
            ]
        ]);
    }

    /**
     * *room_id* [string] # must contains valid "group" room
     * *user_ids*[] [array of string user_ids]
     */
    public function addRoomParticipants($roomId, $userIds = [])
    {
        return $this->post('/api/v2.1/rest/add_room_participants', [
            'json' => [
                'room_id' => $roomId,
                'user_ids' => $userIds
            ]
        ]);
    }

    /**
     * *room_id* [string] # must contains valid "group" room
     * *user_ids* [array of string user_ids]
     */
    public function removeRoomParticipants($roomId, $userIds = [])
    {
        return $this->post('/api/v2.1/rest/remove_room_participants', [
            'json' => [
                'room_id' => $roomId,
                'user_ids' => $userIds
            ]
        ]);
    }

    /**
     * *user_id* [string] required
     * *page* [int] number of page, optional
     * *limit* [int] show n data, maximum and default value is 100
     * *room_type* [string] filter by room type ("single" or "group") default will return all type
     * *show_empty* [boolean, optional default false] if true it will show all rooms that have been created event there are no messages, default is false where only room that have at least one message will be shown
     */
    public function getUserRooms($userId, $page = 1, $limit = 20, $roomType = null, $showEmpty = false)
    {
        return $this->get('/api/v2.1/rest/get_user_rooms', [
            'query' => [
                'user_id' => $userId,
                'page' => $page,
                'limit' => $limit,
                'room_type' => $roomType,
                'show_empty' => $showEmpty
            ]
        ]);
    }

    /**
     * *user_id* [string]
     * *room_id* [string], it can be room_id or room unique id specified by client or auto generated by server
     * *message* [string]
     * *type* [string, default=text]
     * *payload* [string json, optional, see payload definitions bellow]
     * *extras* [string json]
     */
    public function postComment($userId, $roomId, $message, $type = 'text', $payload = NULL, $extras = NULL)
    {
        return $this->post('/api/v2.1/rest/post_comment', [
            'json' => [
                'user_id' => $userId,
                'room_id' => $roomId,
                'message' => $message,
                'type' => $type,
                'payload' => $payload,
                'extras' => $extras
            ]
        ]);
    }

    /**
     * *room_id* [string]
     * *page* [int optional]
     * *limit* [int optional default=20]
     */
    public function loadComments($roomId, $page = 1, $limit = 20)
    {
        return $this->get('/api/v2.1/rest/load_comments', [
            'query' => [
                'room_id' => $roomId,
                'page' => $page,
                'limit' => $limit
            ]
        ]);
    }

    /**
     * *room_id* [string], it can be room_id or room unique id specified by client or auto generated by server
     * *message* [string]
     * *type* [string]
     * *payload* [string json, optional, see payload definitions bellow]
     * *extras* [string json, optional]
     */
    public function postSystemEventMessage($roomId, $message, $type, $payload = [], $extras = [])
    {
        return $this->post('/api/v2.1/rest/post_system_event_message', [
            'json' => [
                'system_event_type' => 'custom',
                'room_id' => $roomId,
                'message' => $message,
                'payload' => array_merge($payload, [
                    'type' => $type
                ]),
                'extras' => $extras
            ]
        ]);
    }

    /**
     * *user_id* [string, required]
     * *room_ids*[] [array of string]
     * *room_channel_ids*[] [array of string, optional]
     */
    public function getUnreadCount($userId, $roomIds = [], $roomUniqueIds = [])
    {
        return $this->get('/api/v2.1/rest/get_unread_count', [
            'query' => [
                'user_id' => $userId,
                'room_ids' => $roomIds,
                'room_channel_ids' => $roomUniqueIds
            ]
        ]);
    }

    /**
     * page [int]
     * show_all [boolean] show all or just partial data using pagination
     * limit [int]
     * order_query [string] example: created_at desc nulls last
     */
    public function getUsers($page = 1, $showAll = false, $limit = 20, $orderQuery = 'created_at desc nulls last')
    {
        return $this->get('/api/v2.1/rest/get_user_list', [
            'query' => [
                'page' => $page,
                'show_all' => $showAll,
                'limit' => $limit,
                'order_query' => $orderQuery
            ]
        ]);
    }

    /**
     * *sender_user_id* [string]
     * *target_user_ids**[]* [array of user id]
     * *message* [string]
     * *type* [string, optional, default=text]
     * *payload* [string json, optional, see payload definitions in post_comment]
     * *extras* [string json, optional] must be valid json string or object
     */
    public function broadcastMessage(
        $senderUserId, 
        $targetUserIds = [], 
        $message, 
        $type = 'text', 
        $payload = [], 
        $extras = []
    )
    {
        return $this->post('/api/v2.1/rest/broadcast', [
            'json' => [
                'sender_user_id' => $senderUserId,
                'target_user_ids' => $targetUserIds,
                'message' => $message,
                'type' => $type,
                'payload' => $payload,
                'extras' => $extras
            ]
        ]);
    }

    /**
     * *room_id* [string]
     * *first_comment_id* [string]
     * *last_comment_id* [string]
     */
    public function loadCommentsWithRange($roomId, $firstCommentId, $lastCommentId)
    {
        return $this->get('/api/v2.1/rest/load_comments_with_range', [
            'query' => [
                'room_id' => $roomId,
                'first_comment_id' => $firstCommentId,
                'last_comment_id' => $lastCommentId
            ]
        ]);
    }

    /**
     * **unique_id* [string] required
     * room_name* [string]
     * *participants*[] [array of string user_id] *at least* *1*
     * *room_avatar_url* [string] optional
     * *room_options* [JSON to string] optional
     */
    public function getOrCreateChannel($uniqueId, $roomName, $participants = [], $roomAvatar, $roomOptions = [])
    {
        return $this->post('/api/v2.1/rest/get_or_create_channel', [
            'json' => [
                'unique_id' => $uniqueId,
                'room_name' => $roomName,
                'participants' => $participants,
                'room_avatar_url' => $roomAvatar,
                'room_options' => $roomOptions
            ]
        ]);
    }

    /**
     * *user_ids* [array of string] *required*
     * *start_date*  [string] in format "YYYY-MM-DD"
     * *end_date*    [string] in format "YYYY-MM-DD"
     */
    public function getUserResponseRate($userIds = [], $startDate, $endDate)
    {
        return $this->get('/api/v2.1/rest/get_user_response_rate', [
            'query' => [
                'user_ids' => $userIds,
                'start_date' => $startDate,
                'end_date' => $endDate
            ]
        ]);
    }

    /**
     * *user_id* [string] *required*
     * *start_time*  [string] in format "YYYY-MM-DD hh:mm:ss"
     * *end_time*    [string] in format "YYYY-MM-DD hh:mm:ss"
     */
    public function getAverageReplyTimeUser($userId, $startTime, $endTime)
    {
        return $this->get('/api/v2.1/rest/get_average_reply_time_user', [
            'query' => [
                'user_id' => $userId,
                'start_time' => $startTime,
                'end_time' => $endTime
            ]
        ]);
    }

    /**
     * *page* [int*] default 1, max 100*
     * *limit* [int] default 20,max 100
     * *type* [string] "mobile" | "rest" | "all" , default all
     */
    public function getWebhookLogs($page = 1, $limit = 20, $type = 'all')
    {
        return $this->get('/api/v2.1/rest/webhook_logs', [
            'query' => [
                'page' => $page,
                'limit' => $limit,
                'type' => $type
            ]
        ]);
    }

    public function getTotalComments($roomId)
    {
        return $this->get('/api/v2.1/rest/total_comments', [
            'query' => [
                'room_id' => $roomId
            ]
        ]);
    }

    public function deactivateUser($userIds = [])
    {
        return $this->delete('/api/v2.1/rest/deactivate_users', [
            'json' => [
                'user_ids' => $userIds
            ]
        ]);
    }

    public function reactivateUser($userIds = [])
    {
        return $this->post('/api/v2.1/rest/reactivate_users', [
            'json' => [
                'user_ids' => $userIds
            ]
        ]);
    }

    public function deleteMessages($uniqueIds = [])
    {
        return $this->post('/api/v2.1/rest/delete_messages', [
            'json' => [
                'unique_ids' => $uniqueIds
            ]
        ]);
    }



    //todo

}
