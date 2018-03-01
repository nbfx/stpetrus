<aside class="main-sidebar">

    <section class="sidebar">

        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset("/img/user-160x160.png") }}" class="img-circle" />
            </div>
            <div class="pull-left info">
                <p>{{ auth()->user()->name }}</p>
            </div>
        </div>

        <?php
        function isActive(string $route):string {
            return request()->route()->getName() == $route ? 'active' : '';
        }
        ?>

        <ul class="sidebar-menu">
            <li class="header">Dashboard menu</li>
            <li class="{{ isActive('main_menu_list') }}"><a href="{{ route('main_menu_list') }}"><i class="fa fa-list" aria-hidden="true"></i>{{ trans('admin.sidebar.usersMenu') }}</a></li>
            <li class="nav-divider"></li>
            <li class="{{ isActive('dishes_list') }}"><a href="{{ route('dishes_list') }}"><i class="fa fa-cutlery" aria-hidden="true"></i>{{ trans('admin.sidebar.dishes') }}</a></li>
            <li class="{{ isActive('teammates_list') }}"><a href="{{ route('teammates_list') }}"><i class="fa fa-users" aria-hidden="true"></i>{{ trans('admin.sidebar.teammates') }}</a></li>
            <li class="{{ isActive('histories_list') }}"><a href="{{ route('histories_list') }}"><i class="fa fa-history" aria-hidden="true"></i>{{ trans('admin.sidebar.histories') }}</a></li>
            <li class="{{ isActive('places_list') }}"><a href="{{ route('places_list') }}"><i class="fa fa-globe" aria-hidden="true"></i>{{ trans('admin.sidebar.places') }}</a></li>
            <li class="{{ isActive('menu_groups_list') }}"><a href="{{ route('menu_groups_list') }}"><i class="fa fa-map-o" aria-hidden="true"></i>{{ trans('admin.sidebar.menuGroups') }}</a></li>
            <li class="{{ isActive('drinks_list') }}"><a href="{{ route('drinks_list') }}"><i class="fa fa-glass" aria-hidden="true"></i>{{ trans('admin.sidebar.drinks') }}</a></li>
            <li class="{{ isActive('wine_groups_list') }}"><a href="{{ route('wine_groups_list') }}"><i class="fa fa-glass" aria-hidden="true"></i>{{ trans('admin.sidebar.wineGroups') }}</a></li>
            {{--<li class="treeview {{ isActive('spirit_groups_list') || isActive('cocktail_groups_list') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-glass" aria-hidden="true"></i><span>{{ trans('admin.sidebar.drinks') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ isActive('spirit_groups_list') }}"><a href="{{ route('spirit_groups_list') }}">{{ trans('admin.sidebar.spiritGroups') }}</a></li>
                    <li class="{{ isActive('cocktail_groups_list') }}"><a href="{{ route('cocktail_groups_list') }}">{{ trans('admin.sidebar.cocktailGroups') }}</a></li>
                </ul>
            </li>--}}
            <li class="{{ isActive('events_list') }}"><a href="{{ route('events_list') }}"><i class="fa fa-calendar" aria-hidden="true"></i>{{ trans('admin.sidebar.events') }}</a></li>
            {{--<li class="treeview {{ isActive('menu_groups_list') }} {{ isActive('menu_items_list') }}">
                <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i><span>{{ trans('admin.sidebar.menu') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ isActive('menu_groups_list') }}"><a href="{{ route('menu_groups_list') }}">{{ trans('admin.sidebar.menuGroups') }}</a></li>

                </ul>
            </li>--}}
            {{--@if(\App\MenuGroup::all()->count())
                <a href="{{ route('menu_items_list') }}">{{ trans('admin.sidebar.menuItems') }}</a>
            @endif--}}
            {{--<li class="treeview {{ isActive('wine_groups_list') }} {{ isActive('wine_items_list') }}">
                <a href="#"><i class="fa fa-map-o" aria-hidden="true"></i><span>{{ trans('admin.sidebar.wine') }}</span><i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ isActive('wine_groups_list') }}"><a href="{{ route('wine_groups_list') }}">{{ trans('admin.sidebar.wineGroups') }}</a></li>
                    @if(\App\WineGroup::all()->count())
                        <li class="{{ isActive('wine_items_list') }}"><a href="{{ route('wine_items_list') }}">{{ trans('admin.sidebar.wineItems') }}</a></li>
                    @endif
                </ul>
            </li>--}}
            <li class="nav-divider"></li>
            <li class="{{ isActive('contacts_edit') }}"><a href="{{ route('contacts_edit') }}"><i class="fa fa-map-marker" aria-hidden="true"></i>{{ trans('admin.sidebar.contacts') }}</a></li>
            <li class="nav-divider"></li>
            <li class="treeview {{ isActive('meta_list') || isActive('images_list') || isActive('languages_list') || isActive('slider_edit') ? 'active' : '' }}">
                <a href="#"><i class="fa fa-cog" aria-hidden="true"></i><span>{{ trans('admin.sidebar.extra') }}</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ isActive('meta_list') }}"><a href="{{ route('meta_list') }}"><i class="fa fa-tags" aria-hidden="true"></i>{{ trans('admin.sidebar.meta') }}</a></li>
                    <li class="{{ isActive('languages_list') }}"><a href="{{ route('languages_list') }}"><i class="fa fa-language" aria-hidden="true"></i>{{ trans('admin.sidebar.languages') }}</a></li>
                    <li class="{{ isActive('slider_edit') }}"><a href="{{ route('slider_edit') }}"><i class="fa fa-picture-o" aria-hidden="true"></i>{{ trans('admin.sidebar.slider') }}</a></li>
                    <li class="{{ isActive('images_list') }}"><a href="{{ route('images_list') }}"><i class="fa fa-file-image-o" aria-hidden="true"></i>{{ trans('admin.sidebar.images') }}</a></li>
                </ul>
            </li>
            {{--<li class="treeview">
                <a href="#"><span>Dishes</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('dishes-add') ? 'active' : '' }}"><a href="{{ route('dishes_add') }}">Add new</a></li>
                    <li class="{{ request()->is('dishes-list') ? 'active' : '' }}"><a href="{{ route('dishes_list') }}">List</a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#"><span>Teammates</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li class="{{ request()->is('teammates-add') ? 'active' : '' }}"><a href="{{ route('teammates_add') }}">Add new</a></li>
                    <li class="{{ request()->is('teammates-list') ? 'active' : '' }}"><a href="{{ route('teammates_list') }}">List</a></li>
                </ul>
            </li>--}}
        </ul>
    </section>
</aside>
