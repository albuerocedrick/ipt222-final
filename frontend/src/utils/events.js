const events = new Map();

export default {
  $on(eventName, fn) {
    if (!events.has(eventName)) {
      events.set(eventName, []);
    }
    events.get(eventName).push(fn);
  },

  $off(eventName, fn) {
    if (events.has(eventName)) {
      const updated = events.get(eventName).filter(cb => cb !== fn);
      events.set(eventName, updated);
    }
  },

  $emit(eventName, data) {
    if (events.has(eventName)) {
      events.get(eventName).forEach(fn => fn(data)); // ← fixed typo here
    }
  }
};