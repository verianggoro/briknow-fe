import type { IShapeDrawer } from "tsparticles/dist/Core/Interfaces/IShapeDrawer";
import type { IParticle } from "tsparticles";
import { Container } from "tsparticles";
import type { IDelta } from "tsparticles/dist/Core/Interfaces/IDelta";
export declare class ConfettiDrawer implements IShapeDrawer {
    getSidesCount(particle: IParticle): number;
    particleInit(container: Container, particle: IParticle): void;
    draw(context: CanvasRenderingContext2D, particle: IParticle, radius: number, opacity: number, delta: IDelta): void;
}
