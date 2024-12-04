// Smooth cursor movement
const cursor = document.querySelector(".cursor");
const follower = document.querySelector(".cursor-follower");

document.addEventListener("mousemove", (e) => {
  const { clientX: x, clientY: y } = e;

  cursor.style.left = `${x}px`;
  cursor.style.top = `${y}px`;

  follower.style.transform = `translate(${x}px, ${y}px)`;
});
