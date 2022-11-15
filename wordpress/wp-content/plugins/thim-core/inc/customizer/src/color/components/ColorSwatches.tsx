const ColorSwatches = ({ colors, onClick }) => {
    return (
        <div className="thim-color-swatches">
            {colors.map((clr, index) => {
                const color = clr && clr.color ? clr.color : clr;

                return (
                    <button
                        key={index.toString()}
                        type="button"
                        className="thim-color-swatch"
                        data-thim-color={color}
                        style={{ backgroundColor: color }}
                        onClick={() => onClick(color)}
                    ></button>
                );
            })}
        </div>
    );
};

export default ColorSwatches;