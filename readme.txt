=== Plugin Name ===
Contributors: gostomski
Tags: user, admin, authentication
Requires at least: 3.0
Tested up to: 3.3.1
Stable tag: trunk

Allows administrators to take on the role of another user for development, testing and troubleshooting purposes without knowing the users password.

== Description ==

The Imposter plugin allows site administrators to take on the role of another user. This is useful for development and testing purposes, as well as the ability to troubleshoot user issues without needing the user password.

It will add a link for each user in the users list, which will log the administrator as that user. They're then logged in as that user and are no longer an administrator, until they logout of the user session, at which point they're logged back in as themselves.

== Installation ==

1. Upload the `imposter` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. That's it!

== Frequently Asked Questions ==

= I can’t see the Impersonate column when listing users =
Currently, only users with the "add_users" capability have access to this, which is just administrators by default. If your a differant user level, or have adjusted the roles and capabilities, you won't see it.

= How do I get back to being myself? = 
To stop impersonating a user, just logout. You will then be logged back in again as yourself.

= My questions not here! =
If you have any other questions, submit a question in the forums.