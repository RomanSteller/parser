<!-- This file is used to store sidebar items, starting with Backpack\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('log') }}'><i class='nav-icon la la-question'></i> Logs</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('logs') }}'><i class='nav-icon la la-question'></i> Logs</a></li>
<li><a href='{{ backpack_url('logs') }}'><i class='fa fa-tag'></i> <span>Tags</span></a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('parse') }}'><i class='nav-icon la la-question'></i> Parses</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('images') }}'><i class='nav-icon la la-question'></i> Images</a></li>
<li class='nav-item'><a class='nav-link' href='{{ backpack_url('images-parse') }}'><i class='nav-icon la la-question'></i> Images Parses</a></li>