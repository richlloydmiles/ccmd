Custom Category MetaData
===

ccmb is a framework used to easily add custom metadata to WordPress taxonomies.

The project is still in its infancy phase but supports the following input types:

* text
* number
* email
* textarea
* select


This project is aimed at WordPress plugin developers to encourage an alternative/progressive way to extend instances of a custom or regular post type.

If you have any suggestions or would like to contribute please contact me at richlloydmiles@gmail.com

Although the framework can be installed as a stand alone plugin in a WordPress installation, it is recommended that you include/require the plugin's files and classes in your own extension.

ccmd can be added to both hierarchical and non-hierachical taxonomies. 
Getting Started
---------------

The majority of the framework's functionality can be seen in the ccmd-example.php file.

1. Create a link to the `init` hook 

`add_action( 'init', 'create_ccmd' );`

2. Create a new instance of the `ccmd` class, passing in the slug of the taxonomy you wish to target. 

`$ccmd = new ccmd('post_tag');`

3. Creating tabbed sections can be achieved by calling the 'add_section' method on the newly created instance, passing in the desired name of the section in as a parameter.

`$ccmd->add_section('sample');`

4. Adding a setting to a section is done via the 'add_setting' method. This method takes an array as of the setting's arguments as its parameter. None of the arguments are required, but it is recommended that it least the `id` and `name` values are set.

`	$args = array(
		'id'=>'the_id' ,
		'name'=>'the_name', 
		'type'=>'text' ,
		'description'=>'' , 
		'section'=>'general'
		);
`