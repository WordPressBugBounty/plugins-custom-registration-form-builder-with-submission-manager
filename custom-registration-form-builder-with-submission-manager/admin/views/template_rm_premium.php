<?php
if (!defined('WPINC')) {
    die('Closed');
}

$rm_premium_purchase_url = 'https://registrationmagic.com/checkout/?edd_action=add_to_cart&download_id=55382';
$rm_premium_plus_purchase_url = 'https://registrationmagic.com/checkout/checkout/?edd_action=add_to_cart&download_id=55393';
?>
<link rel="stylesheet" href="<?php echo esc_url(RM_BASE_URL . 'admin/css/style_rm_premium_revamp.css'); ?>">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">

<div class="rm_pr_page rm-pr-revamp">
    <main class="rm_pr_content" id="rm-pr-content">
        <header class="rm_pr_hero" id="rm-pr-hero" aria-labelledby="rm-pr-hero-title">
            <div class="rm_pr_hero_copy">
                <div class="rm_pr_eyebrow">
                    <?php esc_html_e('Premium upgrade', 'custom-registration-form-builder-with-submission-manager'); ?>
                </div>
                <h1 class="rm_pr_pitch_title" id="rm-pr-hero-title">
                    <?php esc_html_e('Unlock Premium features for your site.', 'custom-registration-form-builder-with-submission-manager'); ?>
                </h1>
                <p class="rm_pitch_details">
                    <?php esc_html_e('Unlock deeper form controls, smarter user workflows, stronger integrations, and the full RegistrationMagic toolkit for production sites.`', 'custom-registration-form-builder-with-submission-manager'); ?>
                </p>
                <div class="rm_pr_action_row">
                    <a class="rm_pr_action rm_pr_action_primary rm_pr_action rm_pr_action_secondary" href="<?php echo esc_url(RM_Utilities::comparison_page_link()); ?>"><?php esc_html_e('View plans', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                </div>
                <div class="rm_pr_hero_trust">
                    <span><?php esc_html_e('1 site license or unlimited sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    <span><?php esc_html_e('1 year or lifetime support', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                </div>
            </div>

            <div class="rm_pr_plan_grid" id="rm-pr-plans">
                <article class="rm_pr_plan_card">
                    <div class="rm_pr_plan_topline"></div>
                    <div class="rm_pr_plan_card_top">
                        <span class="rm_pr_plan_label"><?php esc_html_e('Premium', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span class="rm_pr_plan_best_for"><?php esc_html_e('Best for single sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <strong class="rm_pr_plan_price">$89</strong>
                        <span class="rm_pr_plan_subline"><?php esc_html_e('1 site license', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span class="rm_pr_plan_support"><?php esc_html_e('Updates + support for 1 year', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    </div>
                    <div class="rm_pr_plan_features">
                        <span><?php esc_html_e('Full Premium feature set', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span><?php esc_html_e('Best for one production site', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    </div>
                    <a class="rm_pr_action rm_pr_action_primary rm_pr_plan_action_btn" href="<?php echo esc_url($rm_premium_purchase_url); ?>" target="_blank"><?php esc_html_e('Get Premium', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                    <p class="rm_pr_plan_note"><?php esc_html_e('Best value for a single site.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                </article>

                <article class="rm_pr_plan_card rm_pr_plan_card_alt">
                    <div class="rm_pr_plan_topline rm_pr_plan_topline_alt"></div>
                    <div class="rm_pr_plan_card_top">
                        <span class="rm_pr_plan_label"><?php esc_html_e('Premium+', 'custom-registration-form-builder-with-submission-manager'); ?></span>

                        <span class="rm_pr_plan_best_for"><?php esc_html_e('Best for unlimited sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <strong class="rm_pr_plan_price">$189</strong>
                        <span class="rm_pr_plan_subline"><?php esc_html_e('Unlimited sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span class="rm_pr_plan_support"><?php esc_html_e('Lifetime updates + support', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    </div>
                    <div class="rm_pr_plan_features">
                        <span><?php esc_html_e('Everything in Premium', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span><?php esc_html_e('Built for agencies and multi-site use', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    </div>
                    <a class="rm_pr_action rm_pr_action_primary rm_pr_plan_action_btn" href="<?php echo esc_url($rm_premium_plus_purchase_url); ?>" target="_blank"><?php esc_html_e('Get Premium+', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                    <p class="rm_pr_plan_note"><?php esc_html_e('Best long-term value.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                </article>
            </div>
        </header>

        <section class="rm_pr_feature_block" id="rm-pr-features" aria-labelledby="rm-pr-features-title">
            <div class="rm_pr_feature_box_title">
                <span id="rm-pr-features-title"><?php esc_html_e('Premium capabilities', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                <div class="m_pr_block_mg-logo"><img src="<?php echo plugin_dir_url(dirname(dirname(__FILE__))) . 'images/mg-logo.png'; ?>" alt="RegistrationMagic"></div>
            </div>
            <hr />
            <div class="rm_pr_feature_intro">
                <?php esc_html_e('Explore the premium features available to upgrade your site, organized into six sections for quicker browsing and easier plan comparison.', 'custom-registration-form-builder-with-submission-manager'); ?>
            </div>
            <nav class="rm_pr_section_nav" aria-label="<?php esc_attr_e('Premium sections', 'custom-registration-form-builder-with-submission-manager'); ?>">
                <a href="#rm-pr-group-registration"><span>01</span><?php esc_html_e('Registration', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                <a href="#rm-pr-group-controls"><span>02</span><?php esc_html_e('Form Controls', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                <a href="#rm-pr-group-workflow"><span>03</span><?php esc_html_e('Workflow', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                <a href="#rm-pr-group-reports"><span>04</span><?php esc_html_e('Reports', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                <a href="#rm-pr-group-security"><span>05</span><?php esc_html_e('Security', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                <a href="#rm-pr-group-integrations"><span>06</span><?php esc_html_e('Integrations', 'custom-registration-form-builder-with-submission-manager'); ?></a>
            </nav>

            <div class="rm_pr_block_container">
                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-registration">
                        <span class="rm_pr_feature_group_index">01</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Registration workflows', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Approve users, apply rules, and manage submissions with less manual work.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Core registration tools and data handling', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8DD;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Manual Approvals Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Review and approve individual users instead of default auto registrations. A quick approval link is added to the admin notifications for extra convenience.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE06F;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Submission Notes Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Attach admin notes to user submissions. Frontend notes are visible to users and can be sent as notifications to them.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE812;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Role Based Forms Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Bind user roles to forms so users are assigned the bound role, or let them choose from a list of pre-approved roles.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE638;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Token System Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Generate and provide users a unique token after form submission. The token is also attached to the submission in the dashboard.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE163;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('External Submission Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Forward form data to an external URL using HTTP POST. Useful for connecting RegistrationMagic with other web apps.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE0DA;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Access Control Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Add conditional access control to your form. Allow users within a specific age group, with a secret passphrase, and/or by user role to fill out forms.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE262;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('56 Field Types package', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Full set of custom field types. Now you can build any type of form.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE164;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Export and Filter Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Export all or filtered submissions as CSV, download individual submissions as PDF, and filter by date range.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8A1;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Advanced Paid Registrations Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Add selection boxes, dropdowns, and user-defined price options to paid registrations.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8F7;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Paid User Roles Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Add charges to user roles which appear as payment on forms bound to that role.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE2BC;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Attachments Browser Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('View all attachments as cards in a dedicated area. Download individual attachments or all of them as a zip file.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE429;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Global Overrides Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Override global settings for individual forms when you need form-specific behavior.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE869;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('Custom Field with RegEx Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Use regular expressions to create your own custom fields and accept only specific field values.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE06B;</i></div>
                            <div class="rm_pr_feature_copy">
                                <div class="rm_pr_feature_title"><?php esc_html_e('PDF Branding Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                                <div class="rm_pr_feature_desc"><?php esc_html_e('Brand your submission PDFs and printouts with a customized logo and taglines.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-controls">
                        <span class="rm_pr_feature_group_index">02</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Form controls', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Guide users through cleaner pages, embeds, and smarter field behavior.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Shape how users move through your forms', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE02F;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Multi-Page Form Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Turn forms into multi-step pages with previous and next buttons. Name pages separately and show them above the form fields.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE86F;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('HTML Embed Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Embed your forms where shortcodes cannot go, including third-party pages and different sites.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE86D;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Customizable MagicPopup Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Use Magic Popup as a navigation menu with the option to add custom links.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE415;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('PDF Notification Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Attach the form submission to admin notification emails as a PDF file.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE158;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Email Username Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Use email instead of username during registration so users can log in with their emails too.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE838;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Default Forms Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Assign a registration form as the default form for a user role.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-workflow">
                        <span class="rm_pr_feature_group_index">03</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Admin productivity', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Save time with automation, inboxes, saved searches, and smart field rules.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Tools that reduce repetitive admin work', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE880;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Saved Searches Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Save your regular submission searches as filters for a quick productivity boost.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE0BA;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('User Directory Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Display registered users as a directory on the front end of your site.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8B9;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Automation Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Create automated workflows and tasks to offload manual work to the Automation Manager.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE168;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('User Inbox Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Logged-in users can check all messages they have received from the admin in a dedicated inbox tab.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE0B6;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Conditional Fields Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Add conditional logic to your form fields and control their appearance based on other field values.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8A6;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Unique Values Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Accept only unique values for your form fields so no two users can submit the same value.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE0D0;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('User Submission Cap Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Define a fixed number of times a single user can submit a specific form.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">account_box</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('User Meta Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Define user-meta keys in field settings and save values directly in the WordPress user meta table.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8E8;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Email Verification Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e("Verify user's email address by sending account activation links.", 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE7F4;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Intelligent Contact Form Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Attach message shortcodes that pull user history from your site into submission notifications for deeper insights.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">label</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Custom Status Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Create, customize, and apply custom statuses to submissions to match your approval process.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-reports">
                        <span class="rm_pr_feature_group_index">04</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Reports', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Metrics, comparisons, and scheduled summaries.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Visual reporting and scheduled insights', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE6C4;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Field Analytics Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Pie charts divided by options chosen by users on checkbox, radio, dropdown, and country fields.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">insert_chart</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Advanced Reports Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Take your reports one step further with more options and new comparison abilities.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">mail</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Email Reports Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Configure reports that are sent to your email address as attachments at predefined intervals.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-security">
                        <span class="rm_pr_feature_group_index">05</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Security', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Authentication, anti-spam, and access controls.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Protect access, reduce abuse, and add trust', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE32A;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Advanced Security Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Ban IPs, block spammy domains, reserve usernames, and define password strength options.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">how_to_reg</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('2FA Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Add an extra layer of security and reduce unauthorized access with two-factor authentication.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">block</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Login IP Ban Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Ban visitor IPs based on login behavior and trigger IP block rules.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">verified_user</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Username Validation Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Allow the Username field on login to accept both username and email, or only username.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE8D3;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Social Login Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Let users log in with popular social networks like Google, Twitter, Microsoft, Instagram, and Facebook.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">door_sliding</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Turnstile Antispam Security Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e("Protect your forms from spam bots with Cloudflare Turnstile's non-intrusive detection system.", 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>
                </div>

                <div class="rm_pr_feature_group">
                    <div class="rm_pr_feature_group_heading" id="rm-pr-group-integrations">
                        <span class="rm_pr_feature_group_index">06</span>
                        <div class="rm_pr_feature_group_copy">
                            <h3><?php esc_html_e('Integrations', 'custom-registration-form-builder-with-submission-manager'); ?></h3>
                            <p><?php esc_html_e('Payments, marketing, storage, and delivery.', 'custom-registration-form-builder-with-submission-manager'); ?></p>
                            <div class="rm_pr_feature_group_meta"><?php esc_html_e('Connect registration with the tools you already use', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>

                    <div class="rm_pr_feature_group_cards">
                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/woo_logo_icon.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('WooCommerce Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Combine the power of RegistrationMagic with WooCommerce for a smoother customer flow.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/mailpoet.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('MailPoet Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Subscribe registering users to your MailPoet lists directly from your registration forms.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon rm-mailpoet"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/mailpoet.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('MailPoet 3 Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Subscribe registering users to the latest version of MailPoet lists directly from your registration forms.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/dropbox_icon.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Dropbox Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Automatically upload submission PDFs to your Dropbox folder for archiving and sharing.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/google-map-icon.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Google Maps Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e("Make use of Google Maps inside your forms. Works with Address and Map field types.", 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/mailchimp-icon.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('MailChimp Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Map all your custom fields with registration forms using MailChimp.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/aweber.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Aweber Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Integrate your forms with powerful Aweber systems.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/newsletter-logo.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Newsletter Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Add users to your Newsletter subscriber lists right from your registration forms.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>premium/stripe.png"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Stripe Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Accept payments through the Stripe gateway for paid registrations.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/authorizenet-icon.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Authorize.Net Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Connect your Authorize.Net account as a payment option to start accepting credit card payments.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><img class="rm_feature_icon" src="<?php echo RM_IMG_URL; ?>svg/wepay.svg"></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('WePay Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Accept payments through your forms using the popular WePay gateway.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">&#xE0CE;</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Offline Payments Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('Add more flexibility to payments by turning on offline payments and giving users payment instructions.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>

                        <div class="rm_pr_block_small">
                            <div class="rm_pr_feature_icon"><i class="material-icons">payments</i></div>
                            <div class="rm_pr_feature_title"><?php esc_html_e('Invoices and Payments Ext.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                            <div class="rm_pr_feature_desc"><?php esc_html_e('A separate area to filter and manage form payments with support for custom invoicing.', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <footer class="rm_pr_row rm_pr_banner_row">
            <div class="rm_pr_banner_wrap">
                <div class="rm_pr_banner-copy">
                    <div class="rm_pr_banner-kicker"><?php esc_html_e('Ready to upgrade?', 'custom-registration-form-builder-with-submission-manager'); ?></div>
                    <div class="rm_pr_banner-title">
                        <?php esc_html_e('Pick the plan that fits how you actually build forms.', 'custom-registration-form-builder-with-submission-manager'); ?>
                    </div>
                    <div class="rm_pr_banner-subtitle">
                        <?php esc_html_e('Compare premium plans, review the feature set, and choose the right fit with confidence. Everything is grouped for fast scanning, clearer decisions, and a cleaner upgrade path.', 'custom-registration-form-builder-with-submission-manager'); ?>
                    </div>
                    <div class="rm_pr_banner_pills" aria-label="<?php esc_attr_e('Upgrade highlights', 'custom-registration-form-builder-with-submission-manager'); ?>">
                        <span><?php esc_html_e('53 premium capabilities', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span><?php esc_html_e('6 guided sections', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        <span><?php esc_html_e('Fast comparison', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                    </div>
                </div>
                <div class="rm_pr_footer_plans" id="rm-pr-footer-plans" aria-label="<?php esc_attr_e('Choose a plan', 'custom-registration-form-builder-with-submission-manager'); ?>">
                    <article class="rm_pr_plan_card rm_pr_plan_card_footer">
                        <div class="rm_pr_plan_topline"></div>
                        <div class="rm_pr_plan_card_top">
                            <span class="rm_pr_plan_label"><?php esc_html_e('Premium', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <span class="rm_pr_plan_best_for"><?php esc_html_e('Best for single sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <strong class="rm_pr_plan_price">$89</strong>
                            <span class="rm_pr_plan_subline"><?php esc_html_e('1 site license', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <span class="rm_pr_plan_support"><?php esc_html_e('Updates + support for 1 year', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        </div>
                        <div class="rm_pr_plan_features">
                            <span><?php esc_html_e('Full Premium feature set', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <span><?php esc_html_e('Best for one production site', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        </div>
                        <a class="rm_pr_action rm_pr_action_primary rm_pr_plan_action_btn" href="<?php echo esc_url($rm_premium_purchase_url); ?>" target="_blank"><?php esc_html_e('Get Premium', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                    </article>

                    <article class="rm_pr_plan_card rm_pr_plan_card_alt rm_pr_plan_card_footer">
                        <div class="rm_pr_plan_topline rm_pr_plan_topline_alt"></div>
                        <div class="rm_pr_plan_card_top">
                            <span class="rm_pr_plan_label"><?php esc_html_e('Premium+', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                         
                            <span class="rm_pr_plan_best_for"><?php esc_html_e('Best for unlimited sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <strong class="rm_pr_plan_price">$189</strong>
                            <span class="rm_pr_plan_subline"><?php esc_html_e('Unlimited sites', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <span class="rm_pr_plan_support"><?php esc_html_e('Lifetime updates + support', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        </div>
                        <div class="rm_pr_plan_features">
                            <span><?php esc_html_e('Everything in Premium', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                            <span><?php esc_html_e('Built for agencies and multi-site use', 'custom-registration-form-builder-with-submission-manager'); ?></span>
                        </div>
                        <a class="rm_pr_action rm_pr_action_primary rm_pr_plan_action_btn" href="<?php echo esc_url($rm_premium_plus_purchase_url); ?>" target="_blank"><?php esc_html_e('Get Premium+', 'custom-registration-form-builder-with-submission-manager'); ?></a>
                    </article>
                </div>
            </div>
        </footer>
    </main>
</div>
<script>
    document.body.classList.add('rm-pr-v2-page');
</script>
