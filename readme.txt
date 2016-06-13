{# USING TAG : PER BLOCK CHECKING #}
{% for i in 1..10 %}
	
	{% switcherify loop.index on 'firstItem' %}
		<p style="color:orange">{{ loop.index }} First Item</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'oddItem' %}
		<p style="color:grey">{{ loop.index }} Odd Item</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'evenItem' %}
		<p style="color:blue">{{ loop.index }} Even Item Here</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'lastItem' %}
		<p style="color:green">{{ loop.index }} Last Item Here</p>
	{% endswitcherify %}

	{% switcherify loop.index on 'every3Items' %}
		<p style="color:red">{{ loop.index }} on every 3 items</p>
	{% endswitcherify %}

{% endfor %}

<hr/>

{# USING TAG : ONE BLOCK CHECKING #}
{% for i in 1..10 %}

	{% switcherify loop.index %}

		{% on 'firstItem' %}
			<p style="color:orange">{{ loop.index }} First Item</p>

		{% on 'every3Items' %}
			<p style="color:red">{{ loop.index }} on every 3 items</p>

		{% on 'every5Items' %}
			<p style="color:grey">{{ loop.index }} on every 5 items</p>

	{% endswitcherify %}

{% endfor %}

<hr/>

{# USING FILTER : WITH SET #}
{% for i in 1..10 %}
	{% set className = loop.index | switcherify({
		firstItem    : 'first-class',
		oddItem      : 'odd-class',
		evenItem     : 'even-class',
		every4Items  : '4-class',
	}) %}
	<p class="{{ className }}">
		{{ className }}
	</p>
{% endfor %}

<hr/>

{# USING FILTER : DIRECTLY #}
{% for i in 1..10 %}
	<p class="{{ loop.index | switcherify({ firstItem : 'first-class', oddItem : 'odd-class' }) }}">
		{{ loop.index }}
	</p>
{% endfor %}

<hr/>

{# USING FILTER : WITH ONE DATA #}
{% for i in 1..10 %}
	<p class="{{ loop.index | switcherify( 'every2Items', '2-class') }}">
		{{ loop.index }}
	</p>
{% endfor %}

<hr/>

{# USING FILTER : FOR CHECKING #}
{% for i in 1..10 %}
	{% if loop.index | switcherify( 'evenItem' ) %}
		<p>
			{{ loop.index }}
		</p>
	{% endif %}
{% endfor %}
