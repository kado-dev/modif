<style>
body{
    margin-top:20px;
    background:#F8FCFF;
}
.profile-env > header {
  position: relative;
  z-index: 20;
  margin-top: 30px;
}
.profile-env > header .profile-picture {
  position: relative;
}
.profile-env > header .profile-picture img {
  float: right;
  -moz-box-shadow: 0px 0px 0px 5px rgba(255, 255, 255, 0.9);
  -webkit-box-shadow: 0px 0px 0px 5px rgba(255, 255, 255, 0.9);
  box-shadow: 0px 0px 0px 5px rgba(255, 255, 255, 0.9);
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env > header .profile-picture:hover img {
  zoom: 1;
  -webkit-opacity: 0.5;
  -moz-opacity: 0.5;
  opacity: 0.5;
  filter: alpha(opacity=50);
}
.profile-env > header .profile-info-sections {
  margin: 0;
  padding: 0;
  margin-top: 15px;
  padding-left: 0;
  list-style: none;
  margin-left: -5px;
}
.profile-env > header .profile-info-sections > li {
  display: inline-block;
  padding-left: 5px;
  padding-right: 5px;
}
.profile-env > header .profile-info-sections .profile-name strong,
.profile-env > header .profile-info-sections .profile-name span {
  display: block;
}
.profile-env > header .profile-info-sections .profile-name strong {
  font-size: 18px;
  font-weight: normal;
}
.profile-env > header .profile-info-sections .profile-name span {
  font-size: 12px;
  color: #bbbbbb;
}
.profile-env > header .profile-info-sections .profile-name span a {
  color: #bbbbbb;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env > header .profile-info-sections .profile-name span a:hover {
  color: #888888;
}
.profile-env > header .profile-info-sections .profile-name .user-status {
  position: relative;
  display: inline-block;
  background: #575d67;
  top: -2px;
  margin-left: 5px;
  width: 6px;
  height: 6px;
  -webkit-border-radius: 6px;
  -webkit-background-clip: padding-box;
  -moz-border-radius: 6px;
  -moz-background-clip: padding;
  border-radius: 6px;
  background-clip: padding-box;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env > header .profile-info-sections .profile-name .user-status.is-online {
  background-color: #06b53c;
}
.profile-env > header .profile-info-sections .profile-name .user-status.is-offline {
  background-color: #575d67;
}
.profile-env > header .profile-info-sections .profile-name .user-status.is-idle {
  background-color: #f7d227;
}
.profile-env > header .profile-info-sections .profile-name .user-status.is-busy {
  background-color: #ee4749;
}
.profile-env > header .profile-info-sections .profile-stat h3 {
  font-size: 18px;
  margin-bottom: 5px;
}
.profile-env > header .profile-info-sections .profile-stat span {
  color: #bbbbbb;
}
.profile-env > header .profile-info-sections .profile-stat span a {
  color: #bbbbbb;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env > header .profile-info-sections .profile-stat span a:hover {
  color: #888888;
}
.profile-env > header .profile-info-sections > li {
  padding: 0 40px;
  position: relative;
}
.profile-env > header .profile-info-sections > li + li:after {
  content: '';
  display: block;
  position: absolute;
  top: 15px;
  bottom: 0;
  left: 0;
  width: 1px;
  background: #ebebeb;
  margin: 8px 0;
}
.profile-env > header .profile-info-sections > li:first-child {
  padding-left: 0;
}
.profile-env > header .profile-buttons {
  margin-top: 35px;
}
.profile-env > header .profile-buttons a {
  margin: 0 4px;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section {
  position: relative;
  z-index: 10;
}
.profile-env section.profile-info-tabs {
  position: relative;
  background: #f1f1f1;
  margin-left: -20px;
  margin-right: -20px;
  padding: 20px;
  margin-top: -20px;
  margin-bottom: 30px;
}
.profile-env section.profile-info-tabs .user-details {
  padding-left: 0;
  list-style: none;
}
.profile-env section.profile-info-tabs .user-details li {
  margin-bottom: 10px;
}
.profile-env section.profile-info-tabs .user-details li a {
  color: #a0a0a0;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-info-tabs .user-details li a:hover {
  color: #606060;
}
.profile-env section.profile-info-tabs .user-details li a:hover span {
  color: #e72c28;
}
.profile-env section.profile-info-tabs .user-details li a i {
  margin-right: 5px;
}
.profile-env section.profile-info-tabs .user-details li a span {
  color: #ec5956;
  font-weight: normal;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-info-tabs .nav-tabs {
  position: relative;
  margin-bottom: -20px;
  border-bottom: 0;
}
.profile-env section.profile-info-tabs .nav-tabs > li:first-child a {
  margin-left: 0;
}
.profile-env section.profile-info-tabs .nav-tabs li {
  margin-bottom: 0;
}
.profile-env section.profile-info-tabs .nav-tabs li a {
  border: none;
  padding: 10px 35px;
  font-size: 13px;
  background: #e1e1e1;
  margin-right: 10px;
}
.profile-env section.profile-info-tabs .nav-tabs li.active a {
  background: #fff;
}
.profile-env section.profile-feed {
  margin-bottom: 15px;
  padding-left: 20px;
  padding-right: 20px;
}
.profile-env section.profile-feed .profile-post-form {
  border: 1px solid #ebebeb;
  margin-bottom: 30px;
  -webkit-border-radius: 3px;
  -webkit-background-clip: padding-box;
  -moz-border-radius: 3px;
  -moz-background-clip: padding;
  border-radius: 3px;
  background-clip: padding-box;
}
.profile-env section.profile-feed .profile-post-form .form-control {
  border: none;
  -moz-box-shadow: none;
  -webkit-box-shadow: none;
  box-shadow: none;
  margin: 0;
  background: #fff;
  min-height: 80px;
  -webkit-border-radius: 3px;
  -webkit-background-clip: padding-box;
  -moz-border-radius: 3px;
  -moz-background-clip: padding;
  border-radius: 3px;
  background-clip: padding-box;
}
.profile-env section.profile-feed .profile-post-form .form-options {
  background: #f3f3f3;
  border-top: 1px solid #ebebeb;
  padding: 10px;
}
.profile-env section.profile-feed .profile-post-form .form-options:before,
.profile-env section.profile-feed .profile-post-form .form-options:after {
  content: " ";
  display: table;
}
.profile-env section.profile-feed .profile-post-form .form-options:after {
  clear: both;
}
.profile-env section.profile-feed .profile-post-form .form-options .post-type {
  float: left;
  padding-top: 6px;
}
.profile-env section.profile-feed .profile-post-form .form-options .post-type a {
  margin-left: 10px;
  font-size: 13px;
  color: #aaaaaa;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-feed .profile-post-form .form-options .post-type a:hover {
  color: #303641;
}
.profile-env section.profile-feed .profile-post-form .form-options .post-submit {
  float: right;
}
.profile-env section.profile-feed .profile-post-form .form-options .post-submit .btn {
  padding-left: 20px;
  padding-right: 20px;
}
.profile-env section.profile-feed .profile-stories article.story {
  margin: 30px 0;
}
.profile-env section.profile-feed .profile-stories article.story:before,
.profile-env section.profile-feed .profile-stories article.story:after {
  content: " ";
  display: table;
}
.profile-env section.profile-feed .profile-stories article.story:after {
  clear: both;
}
.profile-env section.profile-feed .profile-stories article.story .user-thumb {
  float: left;
  width: 8%;
}
.profile-env section.profile-feed .profile-stories article.story .user-thumb a img {
  -moz-box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.04);
  -webkit-box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.04);
  box-shadow: 0px 0px 0px 3px rgba(0, 0, 0, 0.04);
}
.profile-env section.profile-feed .profile-stories article.story .story-content {
  float: right;
  width: 92%;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header {
  display: block;
  margin-bottom: 10px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header:before,
.profile-env section.profile-feed .profile-stories article.story .story-content header:after {
  content: " ";
  display: table;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header:after {
  clear: both;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header .publisher {
  float: left;
  color: #9b9fa6;
  font-size: 14px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header .publisher a {
  color: #303641;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header .publisher em {
  display: block;
  font-style: normal;
  font-size: 12px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content header .story-type {
  float: right;
}
.profile-env section.profile-feed .profile-stories article.story .story-content .story-main-content {
  font-size: 13px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content .story-main-content p {
  font-size: 13px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer {
  margin-top: 15px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .liked i {
  color: #ff4e50;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer > a {
  margin-right: 30px;
  display: inline-block;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer > a span {
  zoom: 1;
  -webkit-opacity: 0.6;
  -moz-opacity: 0.6;
  opacity: 0.6;
  filter: alpha(opacity=60);
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments {
  list-style: none;
  margin: 0;
  padding: 0;
  margin-top: 30px;
  border-top: 1px solid #ebebeb;
  padding-top: 20px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li {
  display: table;
  vertical-align: top;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li:before,
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li:after {
  content: " ";
  display: table;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li:after {
  clear: both;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li + li {
  margin-top: 15px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-thumb,
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content {
  display: table-cell;
  vertical-align: top;
  width: 100%;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-thumb {
  width: 1%;
  padding-right: 20px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content {
  border-bottom: 1px solid #ebebeb;
  padding-bottom: 15px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-name {
  font-weight: bold;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta {
  font-size: 11px;
  margin-top: 15px;
  color: #9b9fa6;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta a {
  color: #8d929a;
  margin-right: 5px;
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta a + a {
  margin-left: 5px;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta a i {
  zoom: 1;
  -webkit-opacity: 0.8;
  -moz-opacity: 0.8;
  opacity: 0.8;
  filter: alpha(opacity=80);
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta a:hover {
  color: #737881;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li .user-comment-content .user-comment-meta a:hover i {
  zoom: 1;
  -webkit-opacity: 1;
  -moz-opacity: 1;
  opacity: 1;
  filter: alpha(opacity=100);
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li.comment-form .user-comment-content {
  position: relative;
  border-bottom: 0;
  padding-bottom: 0;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li.comment-form .user-comment-content .form-control {
  background: #eeeeee;
  border: 0;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li.comment-form .user-comment-content .btn {
  position: absolute;
  right: 5px;
  top: 5px;
  border: 0;
  background: transparent;
  color: #737881;
  font-size: 13px;
  zoom: 1;
  -webkit-opacity: 0.7;
  -moz-opacity: 0.7;
  opacity: 0.7;
  filter: alpha(opacity=70);
  -moz-transition: all 300ms ease-in-out;
  -webkit-transition: all 300ms ease-in-out;
  -o-transition: all 300ms ease-in-out;
  transition: all 300ms ease-in-out;
}
.profile-env section.profile-feed .profile-stories article.story .story-content footer .comments li.comment-form .user-comment-content .btn:hover {
  zoom: 1;
  -webkit-opacity: 1;
  -moz-opacity: 1;
  opacity: 1;
  filter: alpha(opacity=100);
}
.profile-env section.profile-feed .profile-stories article.story .story-content hr {
  margin-top: 40px;
}
@media (max-width: 992px) {
  .profile-env > header .profile-picture img {
    width: 90%;
  }
  .profile-env > header .profile-buttons {
    margin-top: 18px;
  }
  .profile-env > header .profile-info-sections .profile-name strong,
  .profile-env > header .profile-info-sections .profile-stat h3 {
    font-size: 16px;
  }
  .profile-env > header .profile-info-sections {
    margin-top: 0;
  }
  .profile-env > header .profile-info-sections > li {
    padding: 0 20px;
  }
  .profile-env section.profile-info-tabs .nav-tabs li a {
    padding-left: 25px;
    padding-right: 25px;
  }
  .profile-env section.profile-feed .profile-stories article.story .user-thumb {
    width: 10%;
  }
  .profile-env section.profile-feed .profile-stories article.story .story-content {
    width: 90%;
  }
}
@media (max-width: 768px) {
  .profile-env section.profile-info-tabs {
    margin-top: 30px;
  }
  .profile-env > header .profile-picture img {
    float: none;
  }
  .profile-env > header .profile-buttons a {
    margin-bottom: 5px;
  }
}
@media (max-width: 601px) {
  .profile-env > header .profile-info-sections {
    margin-bottom: 10px;
  }
  .profile-env > header .profile-info-sections li {
    padding: 15px;
  }
  .profile-env > header .profile-info-sections > li:first-child {
    padding-left: 0;
  }
  .profile-env > header .profile-buttons {
    margin-top: 0;
  }
  .profile-env > header .profile-picture {
    text-align: center;
    display: block;
  }
  .profile-env > header .profile-picture img {
    width: auto;
    float: none;
    display: inline-block;
    margin-bottom: 15px;
  }
  .profile-env section.profile-feed .profile-stories article.story .user-thumb {
    width: 18%;
  }
  .profile-env section.profile-feed .profile-stories article.story .story-content {
    width: 82%;
  }
  .profile-env section.profile-info-tabs .nav-tabs li a {
    padding-left: 15px;
    padding-right: 15px;
    margin-right: 5px;
    font-size: 12px;
  }
  .profile-env section.profile-feed {
    padding: 0;
  }
  .profile-env .col-sm-7,
  .profile-env .col-sm-3 {
    text-align: center;
  }
  .profile-env .col-sm-7 .profile-info-sections,
  .profile-env .col-sm-3 .profile-info-sections,
  .profile-env .col-sm-7 .profile-buttons,
  .profile-env .col-sm-3 .profile-buttons {
    display: inline-block;
  }
  .profile-env > header .profile-info-sections > li + li:after {
    margin: 18px 0;
  }
}
</style>

<div class="container">
    <div class="profile-env">
        <header class="row">
            <div class="col-sm-2">
                <a href="#" class="profile-picture">
                    <img src="https://bootdey.com/img/Content/avatar/avatar7.png" class="img-responsive img-circle"> </a>
            </div>
            <div class="col-sm-7">
                <ul class="profile-info-sections">
                    <li>
                        <div class="profile-name">
                            <strong>
                                <a href="#">Marting flowtlhrow</a>
                                <a href="#" class="user-status is-online tooltip-primary" data-toggle="tooltip" data-placement="top" data-original-title="Online"></a>
                            </strong>
                            <span>
                                <a href="#">Co-Founder at Google</a>
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="profile-stat">
                            <h3>643</h3>
                            <span>
                                <a href="#">followers</a>
                            </span>
                        </div>
                    </li>
                    <li>
                        <div class="profile-stat">
                            <h3>108</h3>
                            <span>
                                <a href="#">following</a>
                            </span>
                        </div>
                    </li>
                </ul>
            </div>
            <div class="col-sm-3">
                <div class="profile-buttons">
                    <a href="#" class="btn btn-default">
                        Follow
                    </a>
                </div>
            </div>
        </header>
        <section class="profile-info-tabs">
            <div class="row">
                <div class="col-sm-offset-2 col-sm-10">
                    <ul class="user-details">
                        <li>
                            <a href="#">
                                <i class="entypo-location"></i>
                                Prishtina
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="entypo-suitcase"></i>
                                Works as
                                <span>Laborator</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="entypo-calendar"></i>
                                16 October
                            </a>
                        </li>
                    </ul>
                    <!-- tabs for the profile links -->
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#profile-info">Profile</a>
                        </li>
                        <li>
                            <a href="#biography">Bio</a>
                        </li>
                        <li>
                            <a href="#profile-edit">Edit Profile</a>
                        </li>
                    </ul>
                </div>
            </div>
        </section>
        <section class="profile-feed">
            <!-- profile post form -->
            <form class="profile-post-form" method="post">
                <textarea class="form-control autogrow" placeholder="What's on your mind?" style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 80px;"></textarea>
                <div class="form-options">
                    <div class="post-type">
                        <a href="#" class="tooltip-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Upload a Picture">
                            <i class="entypo-camera"></i>
                        </a>
                        <a href="#" class="tooltip-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Attach a file">
                            <i class="entypo-attach"></i>
                        </a>
                        <a href="#" class="tooltip-primary" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Check-in">
                            <i class="entypo-location"></i>
                        </a>
                    </div>
                    <div class="post-submit">
                        <button type="button" class="btn btn-primary">POST</button>
                    </div>
                </div>
            </form>
            <!-- profile stories -->
            <div class="profile-stories">
                <article class="story">
                    <aside class="user-thumb">
                        <a href="#">
                            <img src="https://bootdey.com/img/Content/avatar/avatar7.png" width="44" alt="" class="img-circle"> </a>
                    </aside>
                    <div class="story-content">
                        <!-- story header -->
                        <header>
                            <div class="publisher">
                                <a href="#">Marting flowtlhrow</a> posted a status update
                                <em>3 hours ago</em>
                            </div>
                            <div class="story-type">
                                <i class="entypo-feather"></i>
                            </div>
                        </header>
                        <div class="story-main-content">
                            <p>Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Greatly who affixed suppose but enquire compact prepare all put. Added forth chief trees but rooms think may. </p>
                        </div>
                        <!-- story like and comment link -->
                        <footer>
                            <a href="#" class="liked">
                                <i class="entypo-heart"></i>
                                Liked
                                <span>(8)</span>
                            </a>
                            <a href="#">
                                <i class="entypo-comment"></i>
                                Comment
                                <span>(12)</span>
                            </a>
                            <!-- story comments -->
                            <ul class="comments">
                                <li>
                                    <div class="user-comment-thumb">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar1.png" alt="" class="img-circle" width="30"> 
                                    </div>
                                    <div class="user-comment-content">
                                        <a href="#" class="user-comment-name">
                                            John doe
                                        </a>
                                        Tolerably earnestly middleton extremely distrusts she boy now not. Add and offered prepare how cordial two promise. Add and offered prepare how cordial two promise.
                                        <div class="user-comment-meta">
                                            <a href="#" class="comment-date">January 4 at 1:11am</a>
                                            -
                                            <a href="#">
                                                <i class="entypo-heart"></i>
                                                Like
                                                <span>(2)</span>
                                            </a>
                                            -
                                            <a href="#">
                                                <i class="entypo-comment"></i>
                                                Reply
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-comment-thumb">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="" class="img-circle" width="30">   
                                    </div>
                                    <div class="user-comment-content">
                                        <a href="#" class="user-comment-name">
                                            John doe
                                        </a>
                                        Extremity direction existence as dashwoods do up. Securing marianne led welcomed offended but offering six raptures. Conveying concluded newspaper rapturous oh at.
                                        <div class="user-comment-meta">
                                            <a href="#" class="comment-date">January 3 at 6:42pm</a>
                                            -
                                            <a href="#" class="liked">
                                                <i class="entypo-heart"></i>
                                                Liked
                                            </a>
                                            -
                                            <a href="#">
                                                <i class="entypo-comment"></i>
                                                Reply
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="user-comment-thumb">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar4.png" alt="" class="img-circle" width="30">   
                                    </div>
                                    <div class="user-comment-content">
                                        <a href="#" class="user-comment-name">
                                            John doe
                                        </a>
                                        Mean if he they been no hold mr. Is at much do made took held help. Latter person am secure of estate genius at.
                                        <div class="user-comment-meta">
                                            <a href="#" class="comment-date">January 2 at 3:25pm</a>
                                            -
                                            <a href="#">
                                                <i class="entypo-heart"></i>
                                                Like
                                            </a>
                                            -
                                            <a href="#">
                                                <i class="entypo-comment"></i>
                                                Reply
                                            </a>
                                        </div>
                                    </div>
                                </li>
                                <li class="comment-form">
                                    <div class="user-comment-thumb">
                                        <img src="https://bootdey.com/img/Content/avatar/avatar6.png" alt="" class="img-circle" width="30">  
                                    </div>
                                    <div class="user-comment-content">
                                        <textarea class="form-control autogrow" placeholder="Write a comment..." style="overflow: hidden; word-wrap: break-word; resize: horizontal; height: 46px;"></textarea>
                                        <button class="btn">
                                            <i class="entypo-chat"></i>
                                        </button>
                                    </div>
                                </li>
                            </ul>
                        </footer>
                        <!-- separator -->
                        <hr>         
                    </div>
                </article>
                
                <div class="text-center">
                    <a href="#" class="btn btn-default btn-icon icon-left">
                        <i class="entypo-hourglass"></i>
                        Load More …
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>




















<?php
	$kodepuskesmas =  $_SESSION['kodepuskesmas'];
?>

<div class="tableborderdiv">
	<div class="row">
		<div class="col-xs-12">
			<h3 class="judul"><b>DATA PEGAWAI </b></h3>
			<div class="formbg">
				<div class = "row">
					<form role="form">
						<input type="hidden" name="page" value="master_pegawai"/>
						<div class="col-sm-6">
							<input type="text" name="key" class="form-control" value="<?php echo $_GET['key'];?>" placeholder="Ketikan Nama Pegawai" required>
						</div>
						<div class="col-sm-4">
							<button type="submit" class="btn btn-warning btn-white"><span class="fa fa-search"></span></button>
							<a href="?page=master_pegawai" class="btn btn-success  btn-white"><span class="fa fa-refresh"></span></a>
							<?php
								if($_SESSION['otoritas'] == 'ADMINISTRATOR' || $_SESSION['otoritas'] == 'OPERATOR' || $_SESSION['otoritas'] == 'PROGRAMMER'){
							?>
							<button type="submit" class="btn btn-info btnmodalpegawai btn-white"> Tambah Pegawai</button>
							<?php } ?>
						</div>
					</form>
				</div>		
			</div>
		</div>
	</div>

	<!--untuk menampilkan modal-->
	<div class="modal fade" id="modalpegawai" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="myModalLabel"> Entry Pegawai</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" action="index.php?page=master_pegawai_proses" method="post" enctype="multipart/form-data" role="form">
						<table class="table">
							<tr>
								<td class="col-sm-3">Nip</td>
								<td class="col-sm-9">
									<input type="text" name="nip" class="form-control" maxlength ="20" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Nama Pegawai</td>
								<td class="col-sm-9">
									<input type="text" name="namapegawai" style="text-transform: uppercase;" class="form-control" maxlength ="50" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Password</td>
								<td class="col-sm-9">
									<input type="text" name="password" class="form-control" maxlength ="20" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Status</td>
								<td class="col-sm-10">
									<select name="status" class="form-control">
										<option value="-">--Pilih--</option>
										<option value="AKUNTAN">AKUNTAN</option>
										<option value="ANALIS">ANALIS</option>
										<option value="APOTEKER">APOTEKER</option>
										<option value="ASISTEN APOTEKER">ASISTEN APOTEKER</option>
										<option value="BIDAN">BIDAN</option>
										<option value="DOKTER">DOKTER</option>
										<option value="IT">IT</option>
										<option value="KESLING">KESLING</option>
										<option value="KESMAS">KESMAS</option>
										<option value="LOKET">LOKET</option>
										<option value="PERAWAT">PERAWAT</option>
										<option value="NUTRISIONIST">NUTRISIONIST</option>
										<option value="REKAM MEDIS">REKAM MEDIS</option>
										<option value="TU">TU</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Otoritas</td>
								<td class="col-sm-10">
									<input type="checkbox" name="otoritas[]" value="ADMINISTRATOR"> ADMINISTRATOR<br/>
									<input type="checkbox" name="otoritas[]" value="OPERATOR"> OPERATOR<br/>
									<input type="checkbox" name="otoritas[]" value="DINAS KESEHATAN"> DINAS KESEHATAN<br/>
									<input type="checkbox" name="otoritas[]" value="KEPALA UPTD"> KEPALA UPTD<br/>
									<input type="checkbox" name="otoritas[]" value="KEPALA PUSKESMAS"> KEPALA PUSKESMAS<br/>
									<input type="checkbox" name="otoritas[]" value="APOTEK"> APOTEK<br/>
									<input type="checkbox" name="otoritas[]" value="LOKET"> LOKET<br/>
									<input type="checkbox" name="otoritas[]" value="POLI GIGI"> POLI GIGI<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KB"> POLI KB<br/>
									<input type="checkbox" name="otoritas[]" value="POLI KIA"> POLI KIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LABORATORIUM"> POLI LABORATORIUM<br/>
									<input type="checkbox" name="otoritas[]" value="POLI LANSIA"> POLI LANSIA<br/>
									<input type="checkbox" name="otoritas[]" value="POLI UMUM"> POLI UMUM<br/>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Alamat</td>
								<td class="col-sm-9">
									<input type="text" name="alamat" class="form-control" maxlength ="200" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Telepon</td>
								<td class="col-sm-9">
									<input type="text" name="telepon" class="form-control" maxlength ="12" required>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Foto</td>
								<td class="col-sm-9">
									<input type="file" name="image" class="form-control">
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Puskesmas</td>
								<td class="col-sm-10">
									<input type="text" name="puskesmas" class="form-control input-md puskesmas" placeholder="Puskesmas" required>
									<input type="hidden" name="kodepuskesmas" class="form-control kodepuskesmas">
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Loket</td>
								<td class="col-sm-10">
									<select name="loket" class="form-control loketcls">
										<option value="loket 1">loket 1</option>
										<option value="loket 2">loket 2</option>
										<option value="loket 3">loket 3</option>
										<option value="loket 4">loket 4</option>
									</select>
								</td>
							</tr>
							<tr>
								<td class="col-sm-3">Poli</td>
								<td class="col-sm-10">
									<?php
										$sqldttbapelayanan = mysqli_query($koneksi,"SELECT * FROM `tbantrian_pelayanan` where `KodePuskesmas` = '$kodepuskesmas'");
										while($dttbapelayanan = mysqli_fetch_assoc($sqldttbapelayanan)){
									?>
										<label><input type="checkbox" name="poli[]" value="<?php echo $dttbapelayanan['KodePelayanan'];?>"><?php echo $dttbapelayanan['Pelayanan'];?> </label>
									<?php		
										}
									?>	
								</td>
							</tr>
						</table><hr/>
						<button type="submit" class="btnsimpan">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="hasilmodal"></div>

	<!--data-->
	<div class = "row">
		<div class="col-sm-12 table-responsive">
			<table class="table-judul">
				<thead>
					<tr>
						<th width="3%">No.</th>
						<th width="13%">Nip</th>
						<th width="20%">Nama Pegawai</th>
						<th width="30%">Alamat</th>
						<th width="10%">Status</th>
						<th width="10%">Telp.</th>
						<?php
							if($_SESSION['otoritas'] == 'ADMINISTRATOR' || $_SESSION['otoritas'] == 'OPERATOR'|| $_SESSION['otoritas'] == 'PROGRAMMER' || $_SESSION['otoritas'] == 'IMPLEMENTATOR'){
						?>
						<th width="8%">Aksi</th>
						<?php }?>
					</tr>
				</thead>
				<tbody>
					<?php
					$jumlah_perpage = 20;
					
					if($_GET['h']==''){
						$mulai=0;
					}else{
						$mulai= $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}
							
					$key = $_GET['key'];				
					
					if($kodepuskesmas="-"){
						$str = "SELECT * FROM `tbpegawai` WHERE(`NamaPegawai` like '%$key%' OR `Status` like '%like%')";
					}else{
						$str = "SELECT * FROM `tbpegawai` WHERE `KodePuskesmas` = '$kodepuskesmas' AND (`NamaPegawai` like '%$key%' OR `Status` like '%like%')";
					}
					$str2 = $str." order by NamaPegawai Asc LIMIT $mulai,$jumlah_perpage";
					//echo var_dump($str2);
					//die();
					
					if($_GET['h'] == null || $_GET['h'] == 1){
						$no = 0;
					}else{
						$no = $jumlah_perpage * $_GET['h'] - $jumlah_perpage;
					}					
					
					$query = mysqli_query($koneksi,$str2);
					while($data = mysqli_fetch_assoc($query)){
						$no = $no + 1;
						
						// tbpuskesmas
						$kdpkm = $data['KodePuskesmas'];
						$datapkm = mysqli_fetch_assoc(mysqli_query($koneksi,"SELECT * FROM `tbpuskesmas` WHERE `KodePuskesmas` = '$kdpkm'"));
					?>
						<tr>
							<td align="center"><?php echo $no;?></td>
							<td align="left" class="nip"><?php echo $data['Nip'];?></td>
							<td align="left" class="nama"><?php echo $data['NamaPegawai'];?></td>
							<td align="left"><?php echo $data['Alamat'];?></td>
							<td align="center"><?php echo $data['Status'];?></td>
							<td align="center"><?php echo $data['Telepon'];?></td>
							<?php
								if($_SESSION['otoritas'] == 'ADMINISTRATOR' || $_SESSION['otoritas'] == 'OPERATOR'|| $_SESSION['otoritas'] == 'PROGRAMMER' || $_SESSION['otoritas'] == 'IMPLEMENTATOR'){
							?>
							<td align="center">
								<a href="#" class="btnmodalpegawaiedit btn btn-xs btn-info btn-white">Edit</a>
								<a href="?page=master_pegawai_delete&nip=<?php echo $data['Nip'];?>" class="btnmodalpegawaiedit btn btn-xs btn-danger btn-white btnhapus">Hapus</a>
							</td>
							<?php }?>									
						</tr>
					<?php
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
	<hr>
	<ul class="pagination">
		<?php
			$query2 = mysqli_query($koneksi,$str);
			$jumlah_query = mysqli_num_rows($query2);
			
			if(($jumlah_query % $jumlah_perpage) > 0){
				$jumlah = ($jumlah_query / $jumlah_perpage)+1;
			}else{
				$jumlah = $jumlah_query / $jumlah_perpage;
			}
			for ($i=1;$i<=$jumlah;$i++){
			$max = $_GET['h'] + 5;
			$min = $_GET['h'] - 4;
			
				if($i <= $max && $i >= $min){
					if($_GET['h'] == $i){
						echo "<li class='active'><span class='current'>$i</span></li>";
					}else{
						echo "<li><a href='?page=master_pegawai&kategori=$kategori&key=$key&h=$i'>$i</a></li>";
					}
				}
			}
		?>	
	</ul>
</div>	
	