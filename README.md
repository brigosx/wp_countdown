# A fancy countdown plugin for WordPress

Create your own fancy count down for your posts or other WordPress pages. It is based on an idea found on the Internet by <a href="https://bootstrapious.com/p/bootstrap-countdown" target="_blank">BOOTSTRAPIOUS</a> and since it is based on Bootstrap library it is totally responsive.

<h4>Prerequisites</h4>

The plugin uses JQuery version 3.0 so a plugin like the "JQuery Manager" should be installed and activated in order to let the JavaScript library to work fine. If you also use the "Autoptimize" plugin un-check the Javascript Optimization option before activating this plugin.

<h4>Usage</h4>

You can apply a shortcode provided by this plugin anywhere in your WordPress site page or post as in the following examples:

<code>
  [wp_countdown active="true" title="Fancy Countdown Plugin" message="Hey it's Christmas" due_day="2020/12/25"]
</code>

<h4>Plugin parameters</h4>

The plugin offers the following parameters:
<ul>
  <li><strong>active</strong>: Possible values TRUE or FALSE</li>
  <li><strong>title</strong>: A title that will appear at the top (Optional)</li>
  <li><strong>due_day</strong>: The date/time up to the counter will count down. Possible formats yyyy/MM/dd or yyyy/MM/dd HH:mm</li>
  <li><strong>show_day</strong>: The date/time up to the display will be active. Possible formats yyyy/MM/dd or yyyy/MM/dd HH:mm (Optional)</li>
  <li><strong>message</strong>: A text message or HTML code that will be displayed upon finishing the counting (Optional)</li>
  <li><strong>template</strong>: For Elementor use only. Can display a saved Elementor template by using it's title (Optional)</li>
  <li><strong>color</strong>: A gradient background color (default is 1) number. Possible values 1 up to 4 (Optional)</li>
</ul>

<i>The "show_day" parameter should be used in combination with "due_day" and should always be greater than "due_day" parameter.</i>

You may find more details in my article at <a href="https://everfounders.com/x6sl" target="_blank">everfounders.com</a>
