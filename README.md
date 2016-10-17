# Spark

[![Build Status](https://travis-ci.org/cyruscollier/wp-spark.svg?branch=master)](https://travis-ci.org/cyruscollier/wp-spark)

### The object-oriented API you wish WordPress had.

Do you love developing on WordPress? Do you excel at building complex themes, custom plugins and large-scale applications that leverage the best and most popular CMS on the planet? Do you also get frustrated with WordPress's APIs and codebase, and really wished its PHP codebase and APIs were:

- More object-oriented and less procedural?
- More expressive and less repetitive?
- More testable and less tightly coupled?
- More defensive and less error-prone?
- More consistent and less mysterious?

And you wish it had:

- Object-oriented convenience, power and flexibility?
- A sophisticated and robust data model?
- Simple dependency injection with an IOC container?
- Components following industry-standard design patterns?
- A true unit test framework?
- High-level abstractions for common sets of related WordPress tasks and API hooks?

This framework is for you! *Spark* is an expressive and elegant object-oriented API built on top of the standard WordPress APIs. It removes much of the procedural, repetitive and unstructured nature of extending WordPress functionality by providing a series of easy-to-use classes and intention-revealing interfaces that wrap, bundle and abstract many of the common WordPress functions we use every day in our WordPress projects.

## Components:

### Data Model

Spark provides straight-forward entities and value objects to represent internal WordPress concepts and behavior: 

```php
use Spark\Model\PostType;
use Spark\Model\PostType\Post;

global $post;

$Post = Post::createFromPost($post); //instantiate a Spark Post instance from a regualr WP_Post instance

echo $Post->title; // returns a PostTitle value object that automaticaly uses apply_filters('post_title')

echo $Post->published_date->format('l, F jS, Y h:i:sa'); // returns a standard PHP DateTime instance and formats the output

/* Custom Post Type */
class CalendarEvent extends PostType {
	
	const POST_TYPE = 'calendar_event';
	
	/* sets some value object you invent for this field */
	protected function setEventDuration($duration) {
		$this->event_duration = new EventDuration($duration);
	}

	/* a more expressive method to change event time
	public function setEventTime( DateTime $start, DateTime $end ) {
		$this->publish_data = new PostDate( $start );
        $this->event_duration = $this->setEventDuration( $end );
	}
}

```
- Entity classes representing core data types: posts (including post metadata, terms and comments), post types, terms, taxonomies, comments, users, etc.
- Value objects to expressively represent entity properties and their behavior: post title, permalink, email address, 
- Simple and clean model persistence and retrieval using either the Active Record pattern or the Repository pattern
- Model Easily extensible model to express the domain of your WordPress project

Container to register all types of WordPress API extensions: post types, taxonomies, filters, admin pages, events, etc.
