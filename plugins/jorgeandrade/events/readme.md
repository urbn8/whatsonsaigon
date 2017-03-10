## Calendar Events for October Cms

##Installation
Search plugins for **JorgeAndrade.Events** and install it.

## Components

**JorgeAndrade.Events** have two importants components, **eventsList** and **event**

### eventsList
Display a list of events based on a calendar.

```
[eventsList]
eventsPerPage= 10 // default: 10
noEventMessage = 'No events.' // default: No events.
calendar= 1 // default: 1
eventPage = 'events/event' // default: events/event
==

{% component 'eventsList' %}
```

### event
Display a event details.

```
[event]
//this no contain any property.
==

{% component 'event' %}
```

Available vars:
* **event** => Contain the Event object
* **dates** => Contain the relation Event ->Dates object
* **lat** => Contain a latitude of where is the place of event
* **long** => Contain a longitude of where is the place of event