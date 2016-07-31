# Spark

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
use Spark\Model\Post;

$post_id = 123;

$Post = new Post($id); //instantiate a post with ID 123 us

echo $Post->getPostTitle()->unfiltered(); // returns a PostTitle value object and outputs without using apply_filters('post_title')

echo $Post->getPostDate()->format('l, F jS, Y h:i:sa'); // returns a standard PHP DateTime instance and formats the output

/* Custom Post Type */
class CalendarEvent extends Post {

	protected $event_duration; //post meta field automagically added to all instances
	
	public getPostType() {
		return 'calendar_event'; //could also be a constant defined in the class or elsewhere
	}

	/* returns some value object you invent for this field
	public function getEventDuration() {
		return new EventDuration($this->event_duration);
	}
	
	/* a more expressive method to change event time
	public function setEventTime( DateTime $start, DateTime $end ) {
	
	}
}

```
- Entity classes representing core data types: posts (including post metadata, terms and comments), post types, terms, taxonomies, comments, users, etc.
- Value objects to expressively represent entity properties and their behavior: post title, permalink, email address, 
- Simple and clean model persistence and retrieval using either the Active Record pattern or the Repository pattern
- Model Easily extensible model to express the domain of your WordPress project

Container to register all types of WordPress API extensions: post types, taxonomies, filters, admin pages, events, etc.
