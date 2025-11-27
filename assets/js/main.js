const finImage = document.querySelector(".article__img");

finImage.onclick = () => {
  const divFixed = document.createElement("div");
  divFixed.style.position = "fixed";
  divFixed.style.width = "100%";
  divFixed.style.height = "100%";
  divFixed.style.backgroundColor = "rgba(0, 0, 0, 0.8)";
  divFixed.style.display = "flex";
  divFixed.style.justifyContent = "center";
  divFixed.style.alignItems = "center";

  const image = document.createElement("img");
  image.src = finImage.src;
  image.style.maxWidth = "500px";

  divFixed.append(image);
  document.body.append(divFixed);
  document.body.style.overflow = "hidden";

  divFixed.onclick = () => {
    document.body.style.overflow = "";
    image.remove();
    divFixed.remove();
  };
};
