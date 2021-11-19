using System;
using System.Collections.Generic;
using System.Threading.Tasks;
using Application.Shared.Infrastructure.Bootstrapper;
using Microsoft.AspNetCore.Authorization;
using Microsoft.AspNetCore.Mvc;
using Rewards.API.ApplicationServices.ServiceExtensions;
using Rewards.Application.Commands.CreateReward;
using Rewards.Application.Commands.DeleteReward;
using Rewards.Application.Commands.UpdateReward;
using Rewards.Application.Commands.UpdateRewardName;
using Rewards.Application.Commands.UpdateRewardPoint;
using Rewards.Application.Queries.FetchAllRewards;
using Rewards.Application.Queries.FetchReward;
using Rewards.Infrastructure;

namespace Rewards.API.Controllers
{
    [Route("rewards")]
    [ApiController]
    public class RewardsController : ControllerBase
    {
        [AllowAnonymous]
        [HttpPost("create")]
        public async Task<IActionResult> CreateRewardAsync([FromBody] CreateRewardCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, CreateRewardCommand, Guid>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPut("update")]
        public async Task<IActionResult> UpdateRewardAsync([FromBody] UpdateRewardCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, UpdateRewardCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPut("points/update")]
        public async Task<IActionResult> UpdateRewardPointAsync([FromBody] UpdateRewardPointCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, UpdateRewardPointCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpPut("name/update")]
        public async Task<IActionResult> UpdateRewardNameAsync([FromBody] UpdateRewardNameCommand command, [FromServices] IApplication application)
        {
            var response = await application.ExecuteCommandAsync<RewardsModule, UpdateRewardNameCommand>(command);
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet()]
        public async Task<IActionResult> FetchAllRewardsAsync([FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchAllRewardsQuery, IEnumerable<RewardDto>>(new FetchAllRewardsQuery());
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpGet("fetch/{rewardId}")]
        public async Task<IActionResult> FetchRewardAsync(Guid rewardId, [FromServices] IApplication application)
        {
            var response = await application.SendQueryAsync<RewardsModule, FetchRewardQuery, RewardDto>(new FetchRewardQuery(rewardId));
            return response.ResponseResult();
        }

        [AllowAnonymous]
        [HttpDelete("delete/{rewardId}")]
        public async Task<IActionResult> DeleteProductAsync(Guid rewardId, [FromServices] IApplication application)
        {
            var command = new DeleteRewardCommand { Id = rewardId };
            var response = await application.ExecuteCommandAsync<RewardsModule, DeleteRewardCommand>(command);
            return response.ResponseResult();
        }
    }
}
