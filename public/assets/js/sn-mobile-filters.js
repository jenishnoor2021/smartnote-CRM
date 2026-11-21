(function(){'use strict';
 var trigger=document.querySelector('.sn-filter-trigger');
 var panel=document.getElementById('snMobileFilterPanel');
 var close=document.querySelector('.sn-filter-close');
 var backdrop=document.querySelector('.sn-filter-backdrop');
 if(!trigger||!panel||!close||!backdrop)return;
 var previousFocus=null;
 function open(){previousFocus=document.activeElement;document.body.classList.add('sn-filters-open');trigger.setAttribute('aria-expanded','true');panel.setAttribute('role','dialog');panel.setAttribute('aria-modal','true');close.focus();}
 function hide(){if(!document.body.classList.contains('sn-filters-open'))return;document.body.classList.remove('sn-filters-open');trigger.setAttribute('aria-expanded','false');panel.removeAttribute('role');panel.removeAttribute('aria-modal');if(previousFocus&&previousFocus.focus)previousFocus.focus();}
 trigger.addEventListener('click',open);close.addEventListener('click',hide);backdrop.addEventListener('click',hide);
 document.addEventListener('keydown',function(e){if(!document.body.classList.contains('sn-filters-open'))return;if(e.key==='Escape')hide();if(e.key==='Tab'){var els=Array.from(panel.querySelectorAll('button,input,select,a[href],[tabindex]:not([tabindex="-1"])')).filter(function(el){return el.getClientRects().length&&!el.disabled});if(!els.length)return;var first=els[0],last=els[els.length-1];if(e.shiftKey&&document.activeElement===first){e.preventDefault();last.focus()}else if(!e.shiftKey&&document.activeElement===last){e.preventDefault();first.focus()}}});
 window.addEventListener('resize',function(){if(window.innerWidth>=992)hide()});
})();
