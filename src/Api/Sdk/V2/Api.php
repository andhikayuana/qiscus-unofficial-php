<?php

namespace Yuana\Api\Sdk\V2;

use Yuana\Api\BaseApi;

class Api extends BaseApi
{
    /**
     * # required
     * email       string      this is not only email, you can define user id like you want
     * username    string      name of the user
     *
     * # optional
     * password            string      user password, if this value not null, will replaced old user password
     * device_token        string      generated device token from fcm/apns
     * device_platform     string      [android|ios|rn]
     * avatar_url          string      user avatar url
     * extras              json        you can define meta data here using valid json
     *
     */
    public function loginOrRegister(
        $email,
        $username,
        $password,
        $deviceToken,
        $devicePlatform,
        $avatarUrl,
        $extras = []
    )
    {
        return $this->post('/api/v2/rest/login_or_register', [
            'json' => [
                'email' => $email,
                'username' => $username,
                'password' => $password,
                'device_token' => $deviceToken,
                'device_platform' => $devicePlatform,
                'avatar_url' => $avatarUrl,
                'extras' => $extras
            ]
        ]);
    }

    public function getUserProfile($email)
    {
        return $this->get('/api/v2/rest/user_profile', [
            'query' => [
                'user_email' => $email
            ]
        ]);
    }

    /**
     * # required
     * email       string      user email or user id in Qiscus Server
     * 
     * # optional
     * name        string      name of user
     * password    string      user password
     * avatar_url  string      user avatar url
     * extras      json        you can define meta data here using valid json
     * 
     */
    public function updateUserProfile($email)
    {
        return $this->post('/api/v2/rest/update_profile', [
            'json' => [
                'email' => $email
            ]
        ]);
    }

    public function resetUserToken($email)
    {
        return $this->post('/api/v2/rest/reset_user_token', [
            'json' => [
                'user_email' => $email
            ]
        ]);
    }

    public function getUserUnreadCount($emails = [])
    {
        return $this->get('/api/v2/rest/get_user_unread_count', [
            'query' => [
                'user_emails' => $emails
            ]
        ]);
    }

    /**
     * # required
     * name                string      name of group
     * creator             string      user email or user id in Qiscus Server
     * participants[]      string[]    max:25 array of user email or user id for add to group
     * 
     * # optional
     * avatar_url          string      chat room avatar url
     * options             json        you can define meta data with valid json
     * 
     */
    public function createRoom($name, $creator, $participants = [], $avatarUrl = null, $options = [])
    {
        return $this->post('/api/v2/rest/create_room', [
            'json' => [
                'name' => $name,
                'creator' => $creator,
                'participants' => $participants,
                'avatar_url' => $avatarUrl,
                'options' => !empty($options) ? json_encode($options) : NULL
            ]
        ]);
    }

    /**
     * # required
     * emails[]    string[]    array of user email or user id, the array must contains 2 user email or user id
     * 
     * # optional
     * options     json        you can define your own metada in valid json here
     * 
     */
    public function getOrCreateRoomWithTarget($emails = [], $options = [])
    {
        return $this->post('/api/v2/rest/get_or_create_room_with_target', [
            'json' => [
                'emails' => $emails,
                'options' => !empty($options) ? json_encode($options) : NULL
            ]
        ]);
    }

    /**
     * # required
     * unique_id           string      you need to define unique id for channel
     * participants[]      string[]    array of user email or user id for channel
     * 
     * # optional
     * room_name           string      channel name
     * avatar_url          string      channel avatar url
     * options             json        you can define your own metada in valid json here
     * 
     */
    public function getOrCreateChannel(
        $uniqueId,
        $participants = [],
        $name,
        $avatarUrl,
        $options = []
    )
    {
        return $this->post('/api/v2/rest/get_or_create_channel', [
            'json' => [
                'unique_id' => $uniqueId,
                'participants' => $participants,
                'room_name' => $name,
                'avatar_url' => $avatarUrl,
                'options' => !empty($options) ? json_encode($options) : NULL
            ]
        ]);
    }

    /**
     * # required
     * room_id             int         chat room id
     * user_email          string      user email or user id in Qiscus Server
     * 
     * # optional
     * room_name           string      update chat room name
     * room_avatar_url     string      update chat room avatar url
     * options             json        update chat room meta data valid json
     * 
     */
    public function updateRoom(
        $roomId,
        $userEmail,
        $name,
        $avatarUrl,
        $options = []
    )
    {
        return $this->post('/api/v2/rest/update_room', [
            'json' => [
                'room_id' => $roomId,
                'user_email' => $userEmail,
                'room_name' => $name,
                'avatar_url' => $avatarUrl,
                'options' => !empty($options) ? json_encode($options) : NULL
            ]
        ]);
    }

    /**
     * # required
     * user_email      string      user email or user id in Qiscus Server
     * 
     * # optional
     * page                int         default: 1
     * limit               int         default: 100, max:  100
     * type                string      [single|group]
     * show_participants   bool        default: false, not show participants key
     * show_removed        bool        default: false, will show all room that previously participated, default only return room that currently participated only
     * show_empty          bool        default: false, only room that have at least one message will be shown, if true it will show all rooms that have been created event there are no messages
     * 
     */
    public function getUserRooms(
        $userEmail,
        $page = 1,
        $limit = 20,
        $type = 'group',
        $showParticipants = false,
        $showRemoved = false,
        $showEmpty = false
    )
    {
        return $this->get('/api/v2/rest/get_user_rooms', [
            'query' => [
                'user_email' => $userEmail,
                'page' => $page,
                'limit' => $limit,
                'type' => $type,
                'show_participants' => $showParticipants,
                'show_removed' => $showRemoved,
                'show_empty' => $showEmpty
            ]
        ]);
    }

    /**
     * # required
     * user_email              string      user email or user id in Qiscus Server
     * 
     * # optional
     * room_id[]               int[]       max: 100, array of room id
     * room_unique_id[]        string[]    max: 100, array of room unique id
     * show_participants       bool        default: false, not show participants key
     * show_removed            bool        default: false, will show all room that previously participated, default only return room that currently participated only
     * 
     */
    public function getRoomsInfo(
        $userEmail,
        $roomIds = [],
        $roomUniqueIds = [],
        $showParticipants = false,
        $showRemoved = false
    )
    {
        return $this->post('/api/v2/rest/get_rooms_info', [
            'json' => [
                'user_email' => $userEmail,
                'room_id' => $roomIds,
                'room_unique_id' => $roomUniqueIds,
                'show_participants' => $showParticipants,
                'show_removed' => $showRemoved
            ]
        ]);
    }

    /**
     * # required
     * room_id     int         room id
     * emails[]    string[]    array of user email or user id in Qiscus Server
     * 
     */
    public function addRoomParticipants($roomId, $emails = [])
    {
        return $this->post('/api/v2/rest/add_room_participants', [
            'json' => [
                'room_id' => $roomId,
                'emails' => $emails
            ]
        ]);
    }

    /**
     * # required
     * room_id     int         room id
     * emails[]    string[]    array of user email or user id in Qiscus Server
     * 
     */
    public function removeRoomParticipants($roomId, $emails = [])
    {
        return $this->post('/api/v2/rest/remove_room_participants', [
            'json' => [
                'room_id' => $roomId,
                'emails' => $emails
            ]
        ]);
    }

    /**
     * # required
     * room_unique_id      string      chat room unique id
     * 
     * # optional
     * offset              int         default: 0
     * order_by_key_name   string      default: name, [name|joined_at|email]
     * sorting             string      default: asc, [asc|desc]
     * user_name           string      keyword for filter by participant name
     * 
     */
    public function getRoomParticipants(
        $roomUniqueId,
        $offset = 0,
        $orderByKeyName = 'name',
        $sorting = 'asc',
        $username = NULL
    )
    {
        return $this->get('/api/v2/rest/room_participants', [
            'query' => [
                'room_unique_id' => $roomUniqueId,
                'offset' => $offset,
                'order_by_key_name' => $orderByKeyName,
                'sorting' => $sorting,
                'user_name' => $username
            ]
        ]);
    }


    /**
     * # required
     * sender_email        string          user email or user id in Qiscus Server
     * room_id             int|string      room id or room unique id
     * message             string          message content max: 4000
     * 
     * # optional
     * type                string          default: text, [account_linking|button_postback_response|buttons|card|carousel|contact_person|custom|file_attachment|location|reply|text]
     * payload             json            payload for specified type
     * extras              json            you can add meta data in message
     * 
     */
    public function postComment(
        $senderEmail,
        $roomId,
        $message,
        $type = 'text',
        $payload = [],
        $extras = []
    )
    {
        return $this->post('/api/v2/rest/post_comment', [
            'json' => [
                'sender_email' => $senderEmail,
                'room_id' => $roomId,
                'message' => $message,
                'type' => $type,
                'payload' => $payload,
                'extras' => $extras
            ]
        ]);
    }

    /**
     * # required
     * room_id             int         room id in Qiscus Server
     * system_event_type   string      [create_room|add_member|join_room|remove_member|left_room|change_room_name|change_room_avatar|custom
     * 
     * # optional
     * subject_email       string      user email or user id, subject that trigger the system event, required by create_room|add_member|join_room|remove_member|left_room|change_room_name|change_room_avatar
     * object_email[]      string[]    array of user email or user id
     * updated_room_name   string      for change room name type only
     * message             string      message content, max: 5000, required when custom type
     * payload             json
     * extras              json        you can add meta data in message
     * 
     */
    public function postSystemEventMessage(array $args = [])
    {
        return $this->post('/api/v2/rest/post_system_event_message', [
            'json' => $args
        ]);
    }

    public function loadComments($roomId, $page = 1, $limit = 20)
    {
        return $this->get('/api/v2/rest/load_comments', [
            'query' => [
                'room_id' => $roomId,
                'page' => $page,
                'limit' => $limit
            ]
        ]);
    }

    /**
     * # required
     * sender_email    string      user email or user id in Qiscus Server
     * 
     * # optional
     * message     string      the message content, max: 4000
     * emails[]    string[]    array of user id in Qiscus, max: 30, target of the broadcast messages
     * type        string      default: text, [account_linking|button_postback_response|buttons|card|carousel|contact_person|custom|file_attachment|location|reply|text]
     * payload     json        payload for specified type
     * extras      json        you can add meta data in message
     * 
     */
    public function broadcastMessage(
        $senderEmail,
        $message,
        $emails = [],
        $type = 'text',
        $payload = [],
        $extras = []
    )
    {
        return $this->post('/api/v2/rest/broadcast', [
            'json' => [
                'sender_email' => $senderEmail,
                'message' => $message,
                'emails' => $emails,
                'type' => $type,
                'payload' => $payload,
                'extras' => $extras
            ]
        ]);
    }

    
}
