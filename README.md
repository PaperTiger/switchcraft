# Switcherify

A Craft CMS Twig Extension for easier and human readable loop switcher. 

Loop switcher, huh? Let's say in your template you want to display content inside a loop only for every 3rd loop, then on every 9th item, oh and every first and odd item too! Following code will be a way right? :

```Twig
{% for i in 1..10 %}

	{% if loop.index is divisible by (3) %}
		Content here display on every 3rd loop
	{% endif %}
	
	{% if loop.index is divisible by (9) %}
		Content here display on every 9th loop
	{% endif %}
	
	{% if loop.index == 1 %}
		Content here display on first loop
	{% endif %}
	
	{% if loop.index is odd %}
		And content here display on every odd loop
	{% endif %}
	
{% endfor %}
```

With **Switcherify** you can just do this :

```Twig
{% for i in 1..10 %}

	{% switcherify loop.index %}

		{% on 'every3Items' %}
			Content here display on every 3rd loop

		{% on 'every9Items' %}
			Content here display on every 9th loop

		{% on 'firstItem' %}
			Content here display on first loop
			
		{% on 'oddItem' %}
			And content here display on every odd loop

	{% endswitcherify %}

{% endfor %}
```

And of course there are [more options](#usage)!



## Installation
1. Download ZIP and unzip file then place the `switcherify` directory into your `craft/plugins` directory.

2. Install the plugin through Control Panel under `Settings > Plugins`

   ​

## Usage
**Switcherify** comes with two methods : tag and filter, so you can choose them for your convenience.



### Tag

You can use following tag `{% switcherify %} … {% endswitcherify %}` format, there are two ways to use this tag :



#### Tag with direct checking

Format : `{% switcherify loop.index on 'key' %} … {% endswitcherify %}`

```Twig
{% for i in 1..10 %}
	
	{% switcherify loop.index on 'firstItem' %}
		<p>This will be displayed on first loop</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'oddItem' %}
		<p>This will be displayed on odd loop</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'every3Items' %}
		<p>This will only be displayed on every 3rd loop</p>
	{% endswitcherify %}
	
	...

{% endfor %}
```



#### Tag per block checking

Format : `{% switcherify loop.index %} {% on 'key' %} ... {% endswitcherify %}`

```Twig
{% for i in 1..10 %}

	{% switcherify loop.index %}

		{% on 'lastItem' %}
			<p>This will only be displayed on last loop</p>

		{% on 'every9Items' %}
			<p>This will only be displayed on every 9th loop</p>

		{% on 'every5Items' %}
			<p>This will only be displayed on every 5th loop</p>
			
		...

	{% endswitcherify %}

{% endfor %}
```



### Filter

As with tag, **Switcherify**'s filter name is like following : `switcherify`. There are three types of paramaters you can pass :

1. [Array](#array) : `switcherify({ key : 'value', ... })`
2. [Key + Value](#key+value) `switcherify( 'key', 'value' )`
3. [Key Only](#keyonly) : `switcherify( 'key' )`




#### Array

Example usage :

```Twig
{% for i in 1..10 %}

	{% set className = loop.index | switcherify({
		firstItem    : 'sample-first-class',
		oddItem      : 'sample-odd-class',
		evenItem     : 'sample-even-class',
		every2Items  : 'sample-2nd-class',
	}) %}
	
	<p class="{{ className }}"> Content here... </p>
	
{% endfor %}
```

Or if you prefer to pass directly instead store it to variable :

```Twig
{% for i in 1..10 %}

	<p class="{{ loop.index | switcherify({ firstItem : 'sample-first-class', oddItem : 'sample-odd-class' }) }}">
		Content here...
	</p>
	
{% endfor %}
```



#### Key + Value

Example usage :

```Twig
{% for i in 1..10 %}

	<p class="{{ loop.index | switcherify( 'every2Items', 'sample-2nd-class') }}">
		Content here...
	</p>
	
{% endfor %}
```



#### Key only

Especially for this type, **Switcherify** will return a `boolean` value.  Example usage :

```Twig
This will check if loop is in every 3rd loop

{% for i in 1..10 %}

	{% if loop.index | switcherify( 'every3Items' ) %}
		<p> I will only be displayed on every 3rd loop </p>
	{% endif %}
	
{% endfor %}
```



### loop.index

`loop.index` is a required parameter to read where you are. We're working on two additional support though : `loop.index0` and **context aware** inside loop.



### Available Keys

Following are available keys you can use :

- `firstItem` : every *first* loop

- `lastItem` : every *last* loop

- `oddItem` : every *odd* loop

- `evenItem` : every *even* loop

- `everyNItems` : Where **N** is an integer number.

  ​

## License

Copyright 2016 Paper Tiger, Inc.