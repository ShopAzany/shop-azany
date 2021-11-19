using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Application.Shared.Infrastructure.Bootstrapper;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Rewards.API.ApplicationServices.ServiceExtensions;
using Rewards.Application.Commands.CreateUser;
using Rewards.Application.Commands.DeleteUser;
using Rewards.Application.Commands.UpdateUser;
using Rewards.Application.Queries.FetchUser;
using Rewards.Application.Queries.FetchUsers;
using Rewards.Infrastructure;

namespace Rewards.API.Controllers
{
    [Route("users")]
    [ApiController]
    public class UserController : ControllerBase
    {
        [AllowAnonymous]
        [HttpPost("create")]
        public async Task<IActionResult> CreateUserAsync([FromBody] CreateUserCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, CreateUserCommand, Guid>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPut("update")]
        public async Task<IActionResult> UpdateUserAsync([FromBody] UpdateUserCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, UpdateUserCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet()]
        public async Task<IActionResult> FetchAllUsersAsync([FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchUsersQuery, IEnumerable<UserDto>>(new FetchUsersQuery());
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet("{userId}")]
        public async Task<IActionResult> FetchUserAsync(Guid userId, [FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchUserQuery, UserDto>(new FetchUserQuery(userId));
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpDelete("{userId}")]
        public async Task<IActionResult> DeleteProductAsync(Guid userId, [FromServices] IApplication application)
        {
            var command = new DeleteUserCommand { Id = userId };
            var response = await application.ExecuteCommandAsync<RewardsModule, DeleteUserCommand>(command);
            return response.ResponseResult();
        }
    }
}
