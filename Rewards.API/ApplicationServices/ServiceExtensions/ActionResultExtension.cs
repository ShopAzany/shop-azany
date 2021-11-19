using utilities = Application.Shared.Utilities;
using Application.Shared.Utilities;
using Microsoft.AspNetCore.Mvc;

namespace Rewards.API.ApplicationServices.ServiceExtensions
{
    public static class ActionResultExtension
    {
        public static IActionResult ResponseResult(this utilities.ActionResult response)
        {
            return response.Code switch
            {
                ErrorCode.BadRequest => new BadRequestObjectResult(response),
                ErrorCode.NotFound => new NotFoundObjectResult(response),
                ErrorCode.UnAuthorized => new UnauthorizedObjectResult(response),
                ErrorCode.InternalServerError => new ObjectResult(response),
                ErrorCode.OK => new OkObjectResult(response),
                _ => new OkObjectResult(response),
            };
        }
    }
}
