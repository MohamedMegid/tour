<div class="page-sidebar  sidebar-nav">
    <!-- BEGIN SIDEBAR MENU -->
    <ul id="menu" class="page-sidebar-menu">
        <li class="{{ Request::is('admin') ? 'active' : '' }}
                   {{ Request::is(''.Lang::getlocale().'/admin') ? 'active' : '' }}">
            <a href="/{{Lang::getlocale()}}/admin">
                <i class="livicon" data-name="home" data-size="20" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                <span class="title">{{ trans('backend.dashboard') }}</span>
            </a>
        </li>

         <li class="{{ Request::is(''.Lang::getlocale().'/admin/sections/1') ? 'active' : '' }}
         {{ Request::is(''.Lang::getlocale().'/admin/sections/1/*') ? 'active' : '' }}
         {{ Request::is(''.Lang::getlocale().'/admin/sites/1') ? 'active' : '' }}
         {{ Request::is(''.Lang::getlocale().'/admin/sites/1/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="map" data-size="20" data-c="#ffffff" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.tourism_services') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/sections/1') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sections/1">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_sections') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sections/1/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sections/1/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.section') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sites/1') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sites/1">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_sites') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sites/1/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sites/1/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.site') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is(''.Lang::getlocale().'/admin/sections/2') ? 'active' : '' }}
        {{ Request::is(''.Lang::getlocale().'/admin/sections/2/*') ? 'active' : '' }}
        {{ Request::is(''.Lang::getlocale().'/admin/sites/2') ? 'active' : '' }}
        {{ Request::is(''.Lang::getlocale().'/admin/sites/2/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="pin-on" data-size="20" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.tourism_sites') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/sections/2') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sections/2">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_sections') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sections/2/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sections/2/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.section') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sites/2') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sites/2">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_sites') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/sites/2/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/sites/2/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.site') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="{{ Request::is(''.Lang::getlocale().'/admin/comments') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/comments/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="comment" data-size="20" data-c="#ffffff" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.comments') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/comments') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/comments">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_comments') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        {{-- <li class="{{ Request::is(''.Lang::getlocale().'/admin/reviews') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/reviews/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="move" data-size="20" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                <span class="title">{{ trans('backend.reviews') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/reviews') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/reviews">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_reviews') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li> --}}
        <li class="{{ Request::is(''.Lang::getlocale().'/admin/palbum') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/palbum/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="image" data-size="20" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.Photo Gallery') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/palbum') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/palbum">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_photo_albums') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/palbum/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/palbum/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.photo_album') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="{{ Request::is(''.Lang::getlocale().'/admin/videos') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/videos/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="film" data-size="20" data-c="#f2c546" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.videos') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/videos') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/videos">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.videos') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/videos/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/videos/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.videos') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is(''.Lang::getlocale().'/admin/news') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/news/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="pacman" data-size="20" data-c="#ffffff" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.news') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/news') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/news">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_news') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/news/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/news/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.news') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        
        <li class="{{ Request::is('admin/city') ? 'active' : '' }} 
                   {{ Request::is('admin/city/*') ? 'active' : '' }}
                   {{ Request::is(''.Lang::getlocale().'/admin/city') ? 'active' : '' }} 
                   {{ Request::is(''.Lang::getlocale().'/admin/city/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="medal" data-size="20" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.city') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/city/create') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/city/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/city/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }}  {{ trans('backend.city') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is(''.Lang::getlocale().'/admin/city') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/city">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.list_city') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('admin/area') ? 'active' : '' }} 
                   {{ Request::is('admin/area/*') ? 'active' : '' }}
                   {{ Request::is(''.Lang::getlocale().'/admin/area') ? 'active' : '' }} 
                   {{ Request::is(''.Lang::getlocale().'/admin/area/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="lab" data-size="18" data-c="#EF6F6C" data-hc="#EF6F6C" data-loop="true"></i>
                <span class="title">{{ trans('backend.area') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/area/create') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/area/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/area/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }}  {{ trans('backend.area') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is(''.Lang::getlocale().'/admin/area') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/area">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.list_area') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('admin/events') ? 'active' : '' }} 
                   {{ Request::is('admin/events/*') ? 'active' : '' }}
                   {{ Request::is(''.Lang::getlocale().'/admin/events') ? 'active' : '' }} 
                   {{ Request::is(''.Lang::getlocale().'/admin/events/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="list-ul" data-size="18" data-c="#F89A14" data-hc="#F89A14" data-loop="true"></i>
                <span class="title">{{ trans('backend.events') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/events/create') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/events/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/events/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }}  {{ trans('backend.events') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is(''.Lang::getlocale().'/admin/events') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/events">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.list_events') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
        
        <li class="{{ Request::is(''.Lang::getlocale().'/admin/banners') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/banners/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="image" data-size="20" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.banners') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/banners') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/banners">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_banners') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/banners/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/banners/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.banners') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        

        <li class="{{ Request::is(''.Lang::getlocale().'/admin/pages') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/pages/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="doc-portrait" data-size="20" data-c="#ffffff" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.pages') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/pages') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/pages">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.pages') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <!--
                    <li class="{{ Request::is('admin/pages/create') ? 'active' : '' }}">
                        <a href="/{{Lang::getlocale()}}/admin/pages/create">
                            @if(Lang::getlocale() == 'en')
                             <i class="fa fa-angle-double-right"></i>
                            @endif
                            {{ trans('backend.create') }} {{ trans('backend.pages') }}
                            @if(Lang::getlocale() == 'ar')
                              <i class="fa fa-angle-double-left"></i>
                            @endif
                        </a>
                    </li>
                -->
            </ul>
        </li>

        <li class="{{ Request::is(''.Lang::getlocale().'/admin/implinks') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/implinks/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="link" data-size="20" data-c="#ef6f6c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.implinks') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/implinks') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/implinks">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.implinks') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/implinks/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/implinks/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.implinks') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>
		
		
		
		<li class="{{ Request::is(''.Lang::getlocale().'/admin/maptracks') ? 'active' : '' }} 
            {{ Request::is(''.Lang::getlocale().'/admin/maptracks/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="map" data-size="20" data-c="#418BCA" data-hc="#418BCA" data-loop="true"></i>
                <span class="title">{{ trans('backend.Map Tracks') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/maptracks/edit') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/maptracks/edit">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.Map Tracks') }}
                        @if(Lang::getlocale() == 'ar')
                          <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class=" {{ Request::is('admin/contacts') ? 'active' : '' }} 
                    {{ Request::is('admin/contacts/*') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/contacts') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/contacts/*') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/contacts-info') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/contacts-gmap') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="phone" data-size="20" data-c="#EF6F6C" data-hc="#f6bb42" data-loop="true"></i>
                <span class="title">{{ trans('backend.messages') }}</span>
                <span class="fa arrow"></span>
                <span class="badge badge-danger">{{ $counter->NewMessages() }}</span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/contacts') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/contacts') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/contacts">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.new_messages') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/contacts/replied') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/contacts/replied') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/contacts/replied">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                            {{ trans('backend.replied_messages') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/contacts-info') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/contacts-info') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/contacts-info">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                            {{ trans('backend.contacts_info') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/contacts-gmap') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/contacts-gmap') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/contacts-gmap">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                            {{ trans('backend.gmap') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

        <li class=" {{ Request::is(''.Lang::getlocale().'/admin/complains-sections') ? 'active' : '' }} 
                    {{ Request::is(''.Lang::getlocale().'/admin/complains-sections/*') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/complains') ? 'active' : '' }}
                    {{ Request::is(''.Lang::getlocale().'/admin/complains/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="mail" data-size="20" data-c="#337AB7" data-hc="#f6bb42" data-loop="true"></i>
                <span class="title">{{ trans('backend.Complains') }}</span>
                <span class="fa arrow"></span>
                <span class="badge badge-danger">{{ $counter->NewMessagesComplains() }}</span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/complains-sections') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/complains-sections">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.list_sections') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/complains-sections/create') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/complains-sections/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/complains-sections/create">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.create') }} {{ trans('backend.section') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/complains') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/complains') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/complains">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                        {{ trans('backend.New Complains') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is('admin/complains/replied') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/complains/replied') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/complains/replied">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                            {{ trans('backend.Replied Complains') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                
            </ul>
        </li>  

        <li class="{{ Request::is(''.Lang::getlocale().'/admin/users/*') ? 'active' : '' }} {{ Request::is(''.Lang::getlocale().'/admin/users') ? 'active' : '' }}
            {{ Request::is(''.Lang::getlocale().'/admin/activated-users') ? 'active' : '' }}
            {{ Request::is(''.Lang::getlocale().'/admin/deactivated-users') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="user" data-size="20" data-c="#00bc8c" data-hc="#00bc8c" data-loop="true"></i>
                <span class="title">{{ trans('backend.users') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/users') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/users">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('backend.list_users') }}
                    </a>
                </li>
                <li class="{{ Request::is('admin/users/create') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/users/create">
                        <i class="fa fa-angle-double-right"></i>
                        {{ trans('backend.create') }} {{ trans('backend.user') }}
                    </a>
                </li>
            </ul>
        </li>

        <li class="{{ Request::is('admin/settings') ? 'active' : '' }} 
                   {{ Request::is('admin/settings/*') ? 'active' : '' }}
                   {{ Request::is(''.Lang::getlocale().'/admin/settings') ? 'active' : '' }} 
                   {{ Request::is(''.Lang::getlocale().'/admin/settings/*') ? 'active' : '' }}">
            <a href="#">
                <i class="livicon" data-name="ban" data-size="20" data-c="rgb(213, 28, 28)" data-hc="rgb(134, 10, 10)" data-loop="true"></i>
                <span class="title">{{ trans('backend.settings') }}</span>
                <span class="fa arrow"></span>
            </a>
            <ul class="sub-menu">
                <li class="{{ Request::is('admin/settings/email') ? 'active' : '' }}
                           {{ Request::is(''.Lang::getlocale().'/admin/settings/email') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/settings/email">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.smtp_settings') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is(''.Lang::getlocale().'/admin/settings/app-links') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/settings/app-links">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.app_links') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
                <li class="{{ Request::is(''.Lang::getlocale().'/admin/settings/social-media') ? 'active' : '' }}">
                    <a href="/{{Lang::getlocale()}}/admin/settings/social-media">
                        @if(Lang::getlocale() == 'en')
                         <i class="fa fa-angle-double-right"></i>
                        @endif
                         {{ trans('backend.social_media_settings') }}
                        @if(Lang::getlocale() == 'ar')
                         <i class="fa fa-angle-double-left"></i>
                        @endif
                    </a>
                </li>
            </ul>
        </li>

    </ul>
    <!-- END SIDEBAR MENU -->
</div>