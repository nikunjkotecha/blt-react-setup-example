/**
 * Return true if current view is mobile otherwise false.
 */
const isMobile = () => (window.innerWidth < 768);

/**
 * Return the current view of device.
 *
 * @returns boolean
 *   If the device is desktop or not.
 */
const isDesktop = () => (
  window.innerWidth > 1023
);

export {
  isDesktop,
  isMobile,
};
