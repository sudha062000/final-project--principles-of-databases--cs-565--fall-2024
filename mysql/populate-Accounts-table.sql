INSERT INTO Accounts (user_id, site_name, url, password, comment)
VALUES 
(1, 'Facebook', 'https://facebook.com', AES_ENCRYPT('password1', 'encryption_key'), 'Personal account'),
(2, 'Twitter', 'https://twitter.com', AES_ENCRYPT('password2', 'encryption_key'), 'Work account'),
(3, 'Instagram', 'https://instagram.com', AES_ENCRYPT('password3', 'encryption_key'), 'Social account'),
(4, 'LinkedIn', 'https://linkedin.com', AES_ENCRYPT('password4', 'encryption_key'), 'Professional network'),
(5, 'GitHub', 'https://github.com', AES_ENCRYPT('password5', 'encryption_key'), 'Code repository'),
(6, 'Slack', 'https://slack.com', AES_ENCRYPT('password6', 'encryption_key'), 'Team communication'),
(7, 'Pinterest', 'https://pinterest.com', AES_ENCRYPT('password7', 'encryption_key'), 'Visual discovery'),
(8, 'Spotify', 'https://spotify.com', AES_ENCRYPT('password8', 'encryption_key'), 'Music streaming'),
(9, 'Reddit', 'https://reddit.com', AES_ENCRYPT('password9', 'encryption_key'), 'Discussion and community'),
(10, 'YouTube', 'https://youtube.com', AES_ENCRYPT('password10', 'encryption_key'), 'Video sharing platform');
