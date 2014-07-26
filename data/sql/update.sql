-- TABLE UPDATES

-- Version 0.0.1 - June 25 2010

ALTER TABLE rt_site ADD COLUMN reference_key VARCHAR(255);
ALTER TABLE rt_site DROP COLUMN template_dir;
ALTER TABLE rt_site DROP COLUMN is_primary;

-- Version 0.0.2 - June 29 2010

ALTER TABLE rt_address ADD COLUMN instructions TEXT;
ALTER TABLE rt_address ADD COLUMN first_name VARCHAR(100);
ALTER TABLE rt_address ADD COLUMN last_name VARCHAR(100);

ALTER TABLE rt_shop_order ADD COLUMN voucher_code VARCHAR(100);

-- Version 0.0.3 - March 15 2012

ALTER TABLE rt_site ADD COLUMN title VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN domain VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN reference_key VARCHAR(30);
ALTER TABLE rt_site ADD COLUMN content TEXT;
ALTER TABLE rt_site ADD COLUMN published TINYINT(1) DEFAULT '1';
ALTER TABLE rt_site ADD COLUMN ga_code VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN ga_domain VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN facebook_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN flickr_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN youtube_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN devour_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN twitter_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN tumblr_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN email_signature VARCHAR(255) DEFAULT 'Many thanks, The Team';
ALTER TABLE rt_site ADD COLUMN email_address VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN category VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN created_at DATETIME NOT NULL;
ALTER TABLE rt_site ADD COLUMN updated_at DATETIME NOT NULL;

ALTER TABLE rt_site ADD COLUMN public_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN position INT DEFAULT '1';
ALTER TABLE rt_site ADD COLUMN target_link VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN content_summery TEXT;
ALTER TABLE rt_site ADD COLUMN email_contact_address VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN email_contact_response TEXT;
ALTER TABLE rt_site ADD COLUMN html_suffix TEXT;
ALTER TABLE rt_site ADD COLUMN html_snippet_suffix TEXT;
ALTER TABLE rt_site ADD COLUMN email_booking_address VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN email_booking_response TEXT;
ALTER TABLE rt_site ADD COLUMN google_plus_url VARCHAR(255);

-- Version 0.0.4 - March 19 2013

ALTER TABLE rt_site ADD COLUMN sub_title VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN meta_title VARCHAR(255);

ALTER TABLE rt_site CHANGE meta_title meta_title_suffix VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN meta_keywords_suffix VARCHAR(255);

ALTER TABLE rt_site CHANGE meta_keywords_suffix meta_keyword_suffix VARCHAR(255);

ALTER TABLE rt_site ADD COLUMN type VARCHAR(255);

-- Version 0.0.5 - July 15 2013

ALTER TABLE rt_site ADD COLUMN redirects TEXT;

-- Version 0.0.6 - October 23 2013

ALTER TABLE rt_site ADD COLUMN pinterest_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN instagram_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN vimeo_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN admin_email_address VARCHAR(255);


-- Version 0.0.7 - October 23 2013

ALTER TABLE rt_snippet ADD COLUMN uri VARCHAR(255);
ALTER TABLE rt_snippet_version ADD COLUMN uri VARCHAR(255);

ALTER TABLE rt_snippet ADD COLUMN uri_target VARCHAR(255);
ALTER TABLE rt_snippet_version ADD COLUMN uri_target VARCHAR(255);

-- Version 0.0.8 - July 23 2014

ALTER TABLE rt_site ADD COLUMN public_url VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN position INT DEFAULT '1';
ALTER TABLE rt_site ADD COLUMN target_link VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN content_summery TEXT;
ALTER TABLE rt_site ADD COLUMN email_contact_address VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN email_contact_response TEXT;
ALTER TABLE rt_site ADD COLUMN html_suffix TEXT;
ALTER TABLE rt_site ADD COLUMN html_snippet_suffix TEXT;
ALTER TABLE rt_site ADD COLUMN email_booking_address VARCHAR(255);
ALTER TABLE rt_site ADD COLUMN email_booking_response TEXT;
ALTER TABLE rt_site ADD COLUMN google_plus_url VARCHAR(255);

ALTER TABLE rt_page ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_page_version ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_site_page ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_site_page_version ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_blog_page ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_blog_page_version ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';


ALTER TABLE rt_wiki_page ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_wiki_page_version ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';

ALTER TABLE rt_snippet ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';
ALTER TABLE rt_snippet_version ADD COLUMN mode VARCHAR(255) DEFAULT 'standard';


ALTER TABLE rt_page ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_page_version ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_site_page ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_site_page_version ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_blog_page ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_blog_page_version ADD COLUMN title_head VARCHAR(255);


ALTER TABLE rt_wiki_page ADD COLUMN title_head VARCHAR(255);
ALTER TABLE rt_wiki_page_version ADD COLUMN title_head VARCHAR(255);

ALTER TABLE rt_asset ADD COLUMN target_url VARCHAR(255);

