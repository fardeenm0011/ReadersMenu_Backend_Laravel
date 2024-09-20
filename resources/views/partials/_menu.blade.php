<div class="sidebar__menu-group">
    <ul class="sidebar_nav">
        <li>
            <a href="{{ route('dashboard', app()->getLocale()) }}" class="menu-link" data-id="dashboard">
                <span class="nav-icon uil uil-dashboard"></span>
                <span class="menu-text">{{ trans('menu.dashboard-menu-title') }}</span>
            </a>
        </li>
        @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('employee.all', app()->getLocale()) }}" class="menu-link" data-id="employee">
                    <span class="nav-icon uil uil-user"></span>
                    <span class="menu-text">{{ trans('menu.employee-menu-title') }}</span>
                </a>
            </li>
        @endif
        <li>
            <a href="{{ route('category.get', ['language' => app()->getLocale(), 'id' => 'all']) }}" class="menu-link"
                data-id="category">
                <span class="nav-icon uil uil-list-ul"></span>
                <span class="menu-text">{{ trans('menu.category-menu-title') }}</span>
            </a>
        </li>
        @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('comment.all', app()->getLocale()) }}" class="menu-link" data-id="comment">
                    <span class="nav-icon uil uil-comment"></span>
                    <span class="menu-text">{{ trans('menu.comment-menu-title') }}</span>
                </a>
            </li>
        @endif
        @if(Auth::user()->role == 'admin')
            <li>
                <a href="{{ route('baseSetting.all', app()->getLocale()) }}" class="menu-link" data-id="baseSetting">
                    <span class="nav-icon uil uil-setting"></span>
                    <span class="menu-text">{{ trans('menu.baseSetting-menu-title') }}</span>
                </a>
            </li>
        @endif
    </ul>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categoryLinks = document.querySelectorAll('.category-link');
        const menuLinks = document.querySelectorAll('.menu-link');

        // Retrieve the stored category ID and menu ID
        const activeCategoryId = localStorage.getItem('activeCategoryId');
        const activeMenuId = localStorage.getItem('activeMenuId');

        // Highlight the stored category link
        if (activeCategoryId) {
            const activeCategoryLink = document.querySelector(`.category-link[data-id="${activeCategoryId}"]`);
            if (activeCategoryLink) {
                activeCategoryLink.classList.add('active');
            }
        }

        // Highlight the stored menu link
        if (activeMenuId) {
            const activeMenuLink = document.querySelector(`.menu-link[data-id="${activeMenuId}"]`);
            if (activeMenuLink) {
                activeMenuLink.classList.add('active');
            }
        }

        // Add click event to each category link to store the clicked category ID
        categoryLinks.forEach(link => {
            link.addEventListener('click', function () {
                localStorage.setItem('activeCategoryId', this.dataset.id);
            });
        });

        // Add click event to each menu link to store the clicked menu ID
        menuLinks.forEach(link => {
            link.addEventListener('click', function () {
                localStorage.setItem('activeMenuId', this.dataset.id);

                // Clear the stored activeCategoryId when a menu link is clicked
                localStorage.removeItem('activeCategoryId');

                // Remove 'active' class from all category links
                categoryLinks.forEach(link => {
                    link.classList.remove('active');
                });
            });
        });
    });
</script>

<style>
    .category-link.active,
    .menu-link.active {
        color: red;
        /* Change to your preferred highlight color */
    }
</style>