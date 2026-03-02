/**
 * Common Footer Loader
 * Include on any page with:
 *   <div id="common-footer"></div>
 *   <script src="/homepage/footer-loader.js"></script>
 */
(function() {
  var container = document.getElementById('common-footer');
  if (!container) return;

  var xhr = new XMLHttpRequest();
  // Resolve path relative to site root
  var basePath = '';
  var scripts = document.getElementsByTagName('script');
  for (var i = 0; i < scripts.length; i++) {
    if (scripts[i].src && scripts[i].src.indexOf('footer-loader.js') !== -1) {
      basePath = scripts[i].src.replace('footer-loader.js', '');
      break;
    }
  }

  xhr.open('GET', basePath + 'footer.html', true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      container.innerHTML = xhr.responseText;
      // Execute any inline <style> tags
      var styles = container.querySelectorAll('style');
      for (var i = 0; i < styles.length; i++) {
        var s = document.createElement('style');
        s.textContent = styles[i].textContent;
        document.head.appendChild(s);
        styles[i].remove();
      }
    }
  };
  xhr.send();
})();
