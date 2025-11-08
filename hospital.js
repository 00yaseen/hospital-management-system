$(function () {
  $('.has-dropdown').on('click', function (e) {
    e.preventDefault();
    const submenu = $(this).next('.submenu');

    $('.submenu').not(submenu).slideUp(200);
    $('.has-dropdown').not(this).removeClass('active');

    submenu.slideDown(200);
    $(this).addClass('active');
  });

  const currentPage = window.location.pathname.split('/').pop();
  $('.submenu a, .sidebar a').each(function () {
    const linkPage = $(this).attr('href');
    if (linkPage === currentPage) {
      $(this).addClass('active');

      const parentMenu = $(this).closest('.submenu');
      parentMenu.slideDown(0);
      parentMenu.prev('.has-dropdown').addClass('active');
    }
  });
});



