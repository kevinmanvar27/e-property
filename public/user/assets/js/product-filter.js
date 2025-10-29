// howMany = 12;
// listButton = $('button.list-view');
// gridButton = $('button.grid-view');
// wrapper = $('div.wrapper');

// listButton.on('click',function(){
    
//   gridButton.removeClass('on');
//   listButton.addClass('on');
//   wrapper.removeClass('grid').addClass('list');
  
// });

// gridButton.on('click',function(){
    
//   listButton.removeClass('on');
//   gridButton.addClass('on');
//   wrapper.removeClass('list').addClass('grid');
  
// });



// $(document).ready(function() {
//     var listButton = $('button.list-view');
//     var gridButton = $('button.grid-view');
//     var wrapper = $('div.wrapper');

//     // Get last selected view from localStorage
//     var lastView = localStorage.getItem('viewMode') || 'list';

//     if (lastView === 'list') {
//         listButton.addClass('on');
//         gridButton.removeClass('on');
//         wrapper.removeClass('grid').addClass('list');
//     } else {
//         gridButton.addClass('on');
//         listButton.removeClass('on');
//         wrapper.removeClass('list').addClass('grid');
//     }

//     // Button click events
//     listButton.on('click', function() {
//         gridButton.removeClass('on');
//         listButton.addClass('on');
//         wrapper.removeClass('grid').addClass('list');
//         localStorage.setItem('viewMode', 'list');
//     });

//     gridButton.on('click', function() {
//         listButton.removeClass('on');
//         gridButton.addClass('on');
//         wrapper.removeClass('list').addClass('grid');
//         localStorage.setItem('viewMode', 'grid');
//     });
// });
