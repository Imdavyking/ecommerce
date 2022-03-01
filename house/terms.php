<?php

declare(strict_types=1);
session_start();
$root = $_SERVER['DOCUMENT_ROOT'];
require_once("$root/includes/common_data.inc.php");
outPutMinified('htmlStart');
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php require_once "{$constantVar('root')}/partials/meta_tags.php"; ?>
  <link rel="stylesheet" href="<?= $CACHE_BUSTER('/css/terms.min.css') ?>">
  <title>Terms<?= TITLE_HEADING; ?></title>
</head>

<body>
  <div class="page">
    <input id="en" checked="checked" type="radio" name="languages" />
    <header class="header">
      <div class="container">
        <span class="logo">
          <a href="<?= COMPANY_WEBSITE ?>" title="back to home">
            <i class="fa fa-home"></i>
            <?= COMPANY_NAME; ?></a></span>
      </div>
    </header>
    <div class="subnav">
      <div class="container">
        <input class="menu-btn" type="checkbox" id="menu-btn" />
        <label class="menu-icon" for="menu-btn"><span class="navicon"></span> <span class="label-name">Languages</span></label>
        <ul class="menu">
          <li class="en language_label" label-language="en">
            <label for="en">English</label>
          </li>
        </ul>

      </div>
    </div>

    <section>
      <div class="en section_container" section-language="en">
        <div id="md_en" data-target="out_en" class="agreement_md">
          <h1><?= TERM_OF_SERVICE_HEADING; ?></h1>
          <p>Last updated: <?= TERM_OF_SERVICE_LAST_UPDATED_DATE; ?></p>
          <p>Please read this <?= TERM_OF_SERVICE_HEADING; ?> carefully before using Our Service.</p>
          <h1>Interpretation and Definitions</h1>
          <h2>Interpretation</h2>
          <p>The words of which the initial letter is capitalized have meanings defined under the following
            conditions.</p>
          <p>The following definitions shall have the same meaning regardless of whether they appear in
            singular or in plural.</p>
          <h2>Definitions</h2>
          <p>For the purposes of these <?= TERM_OF_SERVICE_HEADING; ?>:</p>
          <ul>
            <li>
              <p><strong>Affiliate</strong> means an entity that controls, is controlled by or is under
                common control with a party, where &quot;control&quot; means ownership of 50% or more of
                the shares, equity interest or other securities entitled to vote for election of
                directors or other managing authority.</p>
            </li>
            <li>
              <p><strong>Company</strong> (referred to as either &quot;the Company&quot;, &quot;We&quot;,
                &quot;Us&quot; or &quot;Our&quot; in this Agreement) refers to
                <?= COMPANY_NAME; ?> , <?= STATE; ?>.</p>
            </li>
            <li>
              <p><strong>COUNTRY</strong> refers to: <?= COUNTRY; ?></p>
            </li>
            <li>
              <p><strong>Device</strong> means any device that can access the Service such as a computer,
                a cellphone or a digital tablet.</p>
            </li>
            <li>
              <p><strong>Service</strong> refers to the Website.</p>
            </li>
            <li>
              <p><strong><?= TERM_OF_SERVICE_HEADING; ?></strong> (also referred as &quot;Terms&quot;) mean these
                <?= TERM_OF_SERVICE_HEADING; ?> that form the entire agreement between You and the Company
                regarding the use of the Service.</p>
            </li>
            <li>
              <p><strong>Third-party Social Media Service</strong> means any services or content
                (including data, information, products or services) provided by a third-party that may
                be displayed, included or made available by the Service.</p>
            </li>
            <li>
              <p><strong>Website</strong> refers to <?= COMPANY_NAME; ?>, accessible from <a href="<?= COMPANY_WEBSITE; ?>" rel="external nofollow noopener" target="_blank"><?= COMPANY_WEBSITE_URL; ?> </a></p>
            </li>
            <li>
              <p><strong>You</strong> means the individual accessing or using the Service, or the company,
                or other legal entity on behalf of which such individual is accessing or using the
                Service, as applicable.</p>
            </li>
          </ul>
          <h1>Acknowledgement</h1>
          <p>These are the <?= TERM_OF_SERVICE_HEADING; ?> governing the use of this Service and the agreement that
            operates between You and the Company. These <?= TERM_OF_SERVICE_HEADING; ?> set out the rights and
            obligations of all users regarding the use of the Service.</p>
          <p>Your access to and use of the Service is conditioned on Your acceptance of and compliance with
            these <?= TERM_OF_SERVICE_HEADING; ?>. These <?= TERM_OF_SERVICE_HEADING; ?> apply to all visitors, users and others
            who access or use the Service.</p>
          <p>By accessing or using the Service You agree to be bound by these <?= TERM_OF_SERVICE_HEADING; ?>. If You
            disagree with any part of these <?= TERM_OF_SERVICE_HEADING; ?> then You may not access the Service.</p>
          <p>You represent that you are age 18 or above. The Company does not permit those under 18 to use the
            Service.</p>
          <p>Your access to and use of the Service is also conditioned on Your acceptance of and compliance
            with the Privacy Policy of the Company. Our Privacy Policy describes Our policies and procedures
            on the collection, use and disclosure of Your personal information when You use the Application
            or the Website and tells You about Your privacy rights and how the law protects You. Please read
            Our Privacy Policy carefully before using Our Service.</p>
          <h1>Links to Other Websites</h1>
          <p>Our Service may contain links to third-party web sites or services that are not owned or
            controlled by the Company.</p>
          <p>The Company has no control over, and assumes no responsibility for, the content, privacy
            policies, or practices of any third party web sites or services. You further acknowledge and
            agree that the Company shall not be responsible or liable, directly or indirectly, for any
            damage or loss caused or alleged to be caused by or in connection with the use of or reliance on
            any such content, goods or services available on or through any such web sites or services.</p>
          <p>We strongly advise You to read the <?= TERM_OF_SERVICE_HEADING; ?> and privacy policies of any third-party
            web sites or services that You visit.</p>
          <h1>Termination</h1>
          <p>We may terminate or suspend Your access immediately, without prior notice or liability, for any
            reason whatsoever, including without limitation if You breach these <?= TERM_OF_SERVICE_HEADING; ?>.</p>
          <p>Upon termination, Your right to use the Service will cease immediately.</p>
          <h1>Limitation of Liability</h1>
          <p></p>
          <h1>&quot;AS IS&quot; and &quot;AS AVAILABLE&quot; Disclaimer</h1>
          <p></p>
          <h1>Governing Law</h1>
          <p></p>
          <h1>Disputes Resolution</h1>
          <p>If You have any concern or dispute about the Service, You agree to first try to resolve the
            dispute informally by contacting the Company.</p>
          <h1>For <?= strtoupper(CONTINENT); ?> Users</h1>
          <p>If You are a <?= CONTINENT; ?> consumer, you will benefit from any mandatory provisions of
            the law of the
            COUNTRY in which you are resident in.</p>
          <h1><?= COUNTRY; ?> Legal Compliance</h1>
          <p>You represent and warrant that (i) You are not located in a COUNTRY that is subject to the
            <?= COUNTRY; ?> government embargo, or that has been designated by the
            <?= COUNTRY; ?> government as a
            &quot;terrorist supporting&quot; COUNTRY, and (ii) You are not listed on any <?= COUNTRY; ?> government
            list of prohibited or restricted parties.</p>
          <h1>Severability and Waiver</h1>
          <h2>Severability</h2>
          <p>If any provision of these Terms is held to be unenforceable or invalid, such provision will be
            changed and interpreted to accomplish the objectives of such provision to the greatest extent
            possible under applicable law and the remaining provisions will continue in full force and
            effect.</p>
          <h2>Waiver</h2>
          <p> </p>
          <h1>Translation Interpretation</h1>
          <p>These <?= TERM_OF_SERVICE_HEADING; ?> may have been translated if We have made them available to You on our
            Service.
            You agree that the original English text shall prevail in the case of a dispute.</p>
          <h1>Changes to These <?= TERM_OF_SERVICE_HEADING; ?></h1>
          <p>We reserve the right, at Our sole discretion, to modify or replace these Terms at any time. If a
            revision is material We will make reasonable efforts to provide at least 30 days' notice prior
            to any new terms taking effect. What constitutes a material change will be determined at Our
            sole discretion.</p>
          <p>By continuing to access or use Our Service after those revisions become effective, You agree to
            be bound by the revised terms. If You do not agree to the new terms, in whole or in part, please
            stop using the website and the Service.</p>
          <h1>Contact Us</h1>
          <p>If you have any questions about these <?= TERM_OF_SERVICE_HEADING; ?>, You can contact us:</p>
          <ul>
            <li>By email: <a href="mailto:<?= COMPANY_EMAIL; ?>"><?= COMPANY_EMAIL ?></a>
            </li>
          </ul>
        </div>
        <div id="out_en" class="agreement_output"></div>
      </div>
    </section>
    <footer>
      <div class="container">
        <?= TERM_OF_SERVICE_HEADING; ?> <?= COMPANY_NAME; ?>
      </div>
    </footer>
  </div>
</body>

</html>