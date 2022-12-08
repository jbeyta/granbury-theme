<?php
/**
 * Template Name: Realtor Template (old)
 * Template Post Type: page
 * Description: Custom page template.
 * @package WordPress
 * @subpackage CW
 * @since CW 2
 */
get_header(); ?>



<div class="main-content affs" role="main">
		<div class="row">
			<div class="s12">
				<?php echo '<h2 class="page-title">'.get_the_title().'</h2>'; ?>
			</div>
		</div>

        <?php
            while(have_posts()) {
                the_post();
                if($post->post_content) {
                    echo '<div class="post-content row">';
                        echo '<div class="s12">';
                            the_content();
                        echo '</div>';
                    echo '</div>';
                }
            }
        ?>

		<div id="realtor-dir">
            <div class="row">
                <div class="s12 controls" style="margin-bottom: 30px;">
                    <input type="text" v-model="search" placeholder="Search Agent Name"  v-if="!loading" />
                    
                    <select v-model="office" v-if="!loading" v-cloak>
                        <option value="">Select an Office</option>
                        <option v-for="(name, slug) in offices" v-bind:value="slug">{{name}}</option>
                    </select>

                    <button v-on:click="clearSearch" v-if="!loading">Clear Search</button>

                    <div class="more-filters">
                        <div class="input-mother" v-if="!loading" v-cloak>
                            <input id="cwlangs" type="checkbox" v-model="langs" value="1">
                            <label for="cwlangs">Additional Languages</label>
                        </div>

                        <div class="input-mother" v-if="!loading" v-cloak>
                            <input id="cwshowAppraisers" type="checkbox" v-model="showAppraisers" value="1">
                            <label for="cwshowAppraisers">Show Appraisers Only</label>
                        </div>
                    </div>

                    <div class="loading" v-if="loading">
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                        <div class="line"></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="s12 realtor-listings">
                    <div class="listing row" v-for="office in filteredResults" v-cloak>
                        <div class="s12 m4">

                            <div class="info" style="width:100%">
                                <div class="image-mother" v-if="office.image_url"><img v-bind:src="office.image_url" alt="" /></div>
                                <div class="image-mother" v-if="office.photo"><img v-bind:src="office.photo" alt="" /></div>

                                <h4 class="title" v-bind:id="office.office_slug">{{office.officename}}</h4>

                                <div
                                    style="margin-bottom: 15px;"
                                    class="address"
                                    v-if="
                                    office.officemailaddress1
                                     || office.officemailcity
                                     || office.officemailstateorprovince
                                     || office.officemailpostalcode
                                    "
                                >
                                    <p style="margin-bottom: 0;" v-if="office.officemailaddress1">{{office.officemailaddress1}}</p>
                                    <p style="margin-bottom: 0;" v-if="office.officemailcity || office.officemailstateorprovince || office.officemailpostalcode">
                                        <span v-if="office.officemailcity">{{office.officemailcity}}</span>
                                        <span v-if="office.officemailcity && office.officemailstateorprovince">, </span>
                                        <span v-if="office.officemailstateorprovince">{{office.officemailstateorprovince}}</span>
                                        <span v-if="office.officemailstateorprovince && office.officemailpostalcode"> </span>
                                        <span v-if="office.officemailpostalcode">{{office.officemailpostalcode}}</span>
                                    </p>
                                </div>

                                <p class="phone" v-if="office.officephone"><b>Office: </b><a v-bind:href="'tel:'+office.officephone">{{office.officephone}}</a></p>
                                <p class="faxphone" v-if="office.officefax"><b>Fax: </b>{{office.officefax}}</p>
                                <p class="email" v-if="office.officeemail"><b>Email: </b><a v-bind:href="'mailto:'+office.officeemail">{{office.officeemail}}</a></p>
                                <p class="website" v-if="office.socialmediawebsiteurlorid"><b>Web: </b><a v-bind:href="office.socialmediawebsiteurlorid">{{office.socialmediawebsiteurlorid}}</a></p>

                                <div class="socials" v-if="office.facebook || office.instagram || office.linkedin || office.twitter || office.socialmediafacebookurlorid || office.socialmedialinkedinurlorid || office.socialmediatwitterurlorid ">
                                    <p class="icon-mother facebook" v-if="office.socialmediafacebookurlorid">
                                        <a v-bind:href="''+office.socialmediafacebookurlorid" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                                        </a>
                                    </p>
                                    <p class="icon-mother facebook" v-if="office.facebook">
                                        <a v-bind:href="''+office.facebook" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                                        </a>
                                    </p>

                                    <p class="icon-mother instagram" v-if="office.instagram">
                                        <a v-bind:href="''+office.instagram" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                                        </a>
                                    </p>

                                    <p class="icon-mother linkedin" v-if="office.socialmedialinkedinurlorid">
                                        <a v-bind:href="''+office.socialmedialinkedinurlorid" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                                        </a>
                                    </p>
                                    <p class="icon-mother linkedin" v-if="office.linkedin">
                                        <a v-bind:href="''+office.linkedin" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                                        </a>
                                    </p>

                                    <p class="icon-mother twitter" v-if="office.socialmediatwitterurlorid">
                                        <a v-bind:href="''+office.socialmediatwitterurlorid" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                                        </a>
                                    </p>

                                    <p class="icon-mother twitter" v-if="office.twitter">
                                        <a v-bind:href="''+office.twitter" target="_blank" rel="noopener nofollow">
                                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="s12 m8">
                            <div class="realtors">
                                <div v-for="office_agent in office.agents" class="realtor" v-if="office_agent.muc != 'Office Staff' && agentIncludes(office_agent)"  v-cloak>
                                    <h5 class="name">{{office_agent.memberfirstname}} {{office_agent.memberlastname}}</h5>

                                    <h6 class="title" v-if="office_agent.title">{{office_agent.title}}</h6>
                                    
                                    <p class="cellphone" v-if="office_agent.membermobilephone"><b>Cell:</b> <a v-bind:href="'tel:'+office_agent.membermobilephone">{{office_agent.membermobilephone}}</a></p>
                                    
                                    <p class="directworkphone" v-if="office_agent.memberdirectphone"><b>Work:</b> <a v-bind:href="'tel:'+office_agent.memberdirectphone">{{office_agent.memberdirectphone}}</a></p>
                                    
                                    <p class="email" v-if="office_agent.memberemail"><a v-bind:href="'mailto:'+office_agent.memberemail">{{office_agent.memberemail}}</a></p>
                                    
                                    <p class="website" v-if="office_agent.socialmediawebsiteurlorid"><a v-bind:href="''+office_agent.socialmediawebsiteurlorid" target="_blank" rel="noopener nofollow">{{office_agent.socialmediawebsiteurlorid}}</a></p>
                                    
                                    <div style="margin-top: 10px;" class="langs" v-if="office_agent.langs" v-html="office_agent.langs"></div>

                                    <div class="socials" v-if="office_agent.socialmediafacebookurlorid || office_agent.facebook || office_agent.instagram || office_agent.socialmedialinkedinurlorid || office_agent.linkedin || office_agent.socialmediatwitterurlorid || office_agent.twitter">
                                        <p class="icon-mother facebook" v-if="office_agent.socialmediafacebookurlorid">
                                            <a v-bind:href="''+office_agent.socialmediafacebookurlorid" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother facebook" v-if="office_agent.facebook">
                                            <a v-bind:href="''+office_agent.facebook" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" class="svg-inline--fa fa-facebook-f fa-w-10" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"><path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother instagram" v-if="office_agent.instagram">
                                            <a v-bind:href="''+office_agent.instagram" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="instagram" class="svg-inline--fa fa-instagram fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother linkedin" v-if="office_agent.socialmedialinkedinurlorid">
                                            <a v-bind:href="''+office_agent.socialmedialinkedinurlorid" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother linkedin" v-if="office_agent.linkedin">
                                            <a v-bind:href="''+office_agent.linkedin" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="linkedin-in" class="svg-inline--fa fa-linkedin-in fa-w-14" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"><path fill="currentColor" d="M100.28 448H7.4V148.9h92.88zM53.79 108.1C24.09 108.1 0 83.5 0 53.8a53.79 53.79 0 0 1 107.58 0c0 29.7-24.1 54.3-53.79 54.3zM447.9 448h-92.68V302.4c0-34.7-.7-79.2-48.29-79.2-48.29 0-55.69 37.7-55.69 76.7V448h-92.78V148.9h89.08v40.8h1.3c12.4-23.5 42.69-48.3 87.88-48.3 94 0 111.28 61.9 111.28 142.3V448z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother twitter" v-if="office_agent.socialmediatwitterurlorid">
                                            <a v-bind:href="''+office_agent.socialmediatwitterurlorid" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                                            </a>
                                        </p>

                                        <p class="icon-mother twitter" v-if="office_agent.twitter">
                                            <a v-bind:href="''+office_agent.twitter" target="_blank" rel="noopener nofollow">
                                                <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="twitter" class="svg-inline--fa fa-twitter fa-w-16" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path fill="currentColor" d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z"></path></svg>
                                            </a>
                                        </p>
                                    </div>

                                    <div class="bio-window" v-if="office_agent.photo || office_agent.bio">
                                        <p class="bio-toggle" v-on:click="toggleBio(office_agent.agent_slug)">
                                            <span v-if="agentHasBioShowing(office_agent.agent_slug)">Hide Bio</span>
                                            <span v-else>Show Bio</span>
                                        </p>

                                        <div class="bio-mother" v-if="agentHasBioShowing(office_agent.agent_slug)">
                                            <div class="inner">
                                                <div class="image" v-if="office_agent.photo"><img v-bind:src="office_agent.photo" alt="" /></div>
                                                <div class="bio" v-if="office_agent.bio" v-html="office_agent.bio"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                    </div>
                </div>
            </div>
		</div>
	</div>

<?php get_footer(); ?>